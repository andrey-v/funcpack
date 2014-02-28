<?php
/**
 * Файл конфигурационных параметров плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 05.10.13 01:39
 */

/** Определение таблиц базы данных */
Config::Set('db.table.funcpack_sclonenie', '___db.table.prefix___funcpack_sclonenie'); // Таблица склонений

return array(

    // Использовать ли прокси-методы
    'use_proxy_method' => true,

    // Использовать ли валидаторы
    'use_validators' => true,

    /**
     * Режим работы склоянтора
     *  - 'only_ya'     - только через yandex
     *  - 'only_bd'     - только по БД
     *  - 'both'   - совмещенный режим
     *  - 'no'     - отключено
     */
    'sclonyator_mode'     => 'both',

);
