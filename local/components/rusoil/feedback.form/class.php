<?php

namespace Rusoil\Components;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Mail\Event;
use CAllMain;
use CAllUser;
use CMain;
use CSite;
use CUser;
use PHPMailer\PHPMailer\Exception;
use Rusoil\Components\Helpers\MessageHelper;

class FeedbackFormComponent extends \CBitrixComponent implements Controllerable, Errorable
{
    protected ErrorCollection $errorCollection;

    public function onPrepareComponentParams($arParams): array
    {
        $this->errorCollection = new ErrorCollection();
        return $arParams;
    }

    public function getErrors(): array
    {
        return $this->errorCollection->toArray();
    }

    public function getErrorByCode($code): \Bitrix\Main\Error
    {
        return $this->errorCollection->getErrorByCode($code);
    }

    public function configureActions(): array
    {
        return [
            'submitForm' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST,
                    ]),
                    new Csrf(),
                ],
            ],
        ];
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    /**
     * @throws ArgumentTypeException
     * @throws Exception
     */
    public function submitFormAction(): array
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $fields = $request->getValues();
        $message = MessageHelper::prepareMessage($fields);
        $fileIds = false;

        if ($_FILES['file']) {
            foreach ($_FILES['file'] as $file) {
                $fileIds[] = \CFile::SaveFile($file, "mailatt");
            }
        }

        $rsSites = CSite::GetByID(SITE_ID);
        $arSite = $rsSites->Fetch();
        $strEmail = $arSite['EMAIL'];

        $userEmail = $this->_user()->GetEmail();

        if ($strEmail && $userEmail) {
            Event::sendImmediate([
                "EVENT_NAME" => "FEEDBACK_FORM_RUSOIL",
                "LID"        => "s2",
                "C_FIELDS"   => [
                    "EMAIL"      => $strEmail,
                    "MESSAGE"    => $message,
                    "USER_NAME"  => $this->_user()->GetFullName(),
                    "USER_EMAIL" => $userEmail,
                ],
                "FILE"       => $fileIds,
            ]);

            if ($fileIds) {
                foreach ($fileIds as $fileId) {
                    \CFile::Delete($fileId);
                }
            }
            return ['success' => 'Y'];
        }

        if ($fileIds) {
            foreach ($fileIds as $fileId) {
                \CFile::Delete($fileId);
            }
        }
        throw new Exception('Email not found', 400);
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllUser|CUser
     */
    private function _user(): CAllUser|CUser
    {
        global $USER;
        return $USER;
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllMain|CMain
     */
    private function _app(): CMain|CAllMain
    {
        global $APPLICATION;
        return $APPLICATION;
    }
}
