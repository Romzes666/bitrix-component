<?php

namespace Rusoil\Components\Helpers;

class MessageHelper
{
    public static function prepareMessage($fields): string
    {
        $result = $fields['title'] . PHP_EOL;
        $result .= 'Категория: ' . $fields['category'] . PHP_EOL;
        $result .= 'Вид заявки: ' . $fields['type_feed'] . PHP_EOL;
        $result .= 'Склад поставки: ' . $fields['store'] . PHP_EOL;
        $result .= 'Комментарий: ' . $fields['comment'] . PHP_EOL;

        for ($i = 0; $i < $fields['rows']; $i++) {
            $result .= PHP_EOL . 'Бренд: ' . $fields['brand'][$i] . PHP_EOL;
            $result .= 'Наименование: ' . $fields['nomination'][$i] . PHP_EOL;
            $result .= 'Количество: ' . $fields['count'][$i] . PHP_EOL;
            $result .= 'Фасовка: ' . $fields['packaging'][$i] . PHP_EOL;
        }
        $result .= PHP_EOL;

        return $result;
    }
}
