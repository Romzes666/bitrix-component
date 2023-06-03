<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("FEEDBACK_COMPONENT"),
    "DESCRIPTION" => "",
    "PATH" => [
        "ID" => Loc::getMessage("FEEDBACK_COMPONENT_PATH_ID"),
        "CHILD" => [
            "ID" => Loc::getMessage("FEEDBACK_COMPONENT_CHILD_PATH_ID"),
            "NAME" => Loc::getMessage("FEEDBACK_COMPONENT_NAME")
        ]
    ],
];
?>
