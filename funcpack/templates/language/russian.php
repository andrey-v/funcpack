<?php
/**
 * Файл локализации для русского языка плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 05.10.13 01:37
 */
return array(
    // Описание ядра пакета
    'core_version_name'                => 'ProblemCode RC 1',
    'core_version_date'                => '12 октября 2013 года',
    '',

    // Валидаторы значений
    // ValidatorBoolean
    'validator_default_boolean_strict' => 'Указанное значение "%%xValue%%" не является правильным, значение должно быть равно либо "%%xTrueValue%%" либо "%%xFalseValue%%", в том числе по типу',
    'validator_default_boolean'        => 'Указанное значение "%%xValue%%" не является правильным, значение должно быть равно "%%xTrueValue%%" или "%%xFalseValue%%", либо приводиться к ним по типу',

    // ValidatorUrl
    'validator_default_url'            => 'Указанное значение "%%xValue%%" не является правильным url-адресом.',

    // ValidatorCompare
    'validator_compare_eq'             => 'Значение %%xValue%% и значение %%xRequiredValue%% должны быть равны.',
    'validator_compare_not_eq'         => 'Значение %%xValue%% и значение %%xRequiredValue%% НЕ должны быть равны.',
    'validator_compare_rt'             => 'Значение %%xValue%% должно быть больше значения %%xRequiredValue%%.',
    'validator_compare_rt_eq'          => 'Значение %%xValue%% должно быть больше либо равно значению %%xRequiredValue%%.',
    'validator_compare_lt'             => 'Значение %%xValue%% должно быть меньше значения %%xRequiredValue%%.',
    'validator_compare_lt_eq'          => 'Значение %%xValue%% должно быть меньше либо равно значению %%xRequiredValue%%.',
    'validator_compare_default'        => 'Ошибочное значение оператора %%sOperator%%',

    // ValidatorDate
    'validator_date_eq'                => 'Дата %%xValue%% и дата %%xRequiredValue%% должны быть равны.',
    'validator_date_not_eq'            => 'Дата %%xValue%% и дата %%xRequiredValue%% НЕ должны быть равны.',
    'validator_date_rt'                => 'Дата %%xValue%% должны быть больше даты %%xRequiredValue%%.',
    'validator_date_rt_eq'             => 'Дата %%xValue%% должны быть больше либо равно дате %%xRequiredValue%%.',
    'validator_date_lt'                => 'Дата %%xValue%% должны быть меньше даты %%xRequiredValue%%.',
    'validator_date_lt_eq'             => 'Дата %%xValue%% должны быть меньше либо равно дате %%xRequiredValue%%.',
    'validator_date_default'           => 'Ошибочное значение оператора %%sOperator%%',
    'validator_date_format'            => 'Формат даты %%xValue%% ошибочен. Формат должен быть такой: "%%sFormat%%"',
    'validator_date_format_required'   => 'Формат требуемой даты %%xValue%% ошибочен. Формат должен быть такой: "%%sFormat%%"',

    // ValidatorType
    'validator_type_default'           => 'Тип значения "%%xValue%%" не соответствует типу "%%sType%%"',

    // ValidatorString
    'validator_string_range'           => 'Длина строки "%%xValue%%" должна находиться в диапазоне от %%iMin%% до %%iMax%% символов',
    'validator_string_min'             => 'Длина строки "%%xValue%%" должна быть больше %%iMin%% символов',
    'validator_string_max'             => 'Длина строки "%%xValue%%" должна быть меньше %%iMax%% символов',
    'validator_string_length'          => 'Длина строки "%%xValue%%" должна быть равна точно %%iLength%% символов',
    'validator_string_format'          => 'Указанное значение "%%xValue%%" не является строкой',
    'validator_string_default'         => 'Указанное значение "%%xValue%%" ошибочно',

    // ValidatorNumber
    'validator_number_number'          => 'Указанное значение "%%xValue%%" не является числом.',
    'validator_number_integer'         => 'Указанное значение "%%xValue%%" должно быть целым числом.',
    'validator_number_to_small'        => 'Указанное значение "%%xValue%%" должно быть больше "%%iMin%%".',
    'validator_number_to_big'          => 'Указанное значение "%%xValue%%" должно быть меньше "%%iMax%%".',
    'validator_number_default'         => 'Указанное значение "%%xValue%%" не допустимо.',

    // ValidatorEmail
    'validator_email_email'            => 'Ошибка в представлении адреса электронной почты',
    'validator_email_mx'               => 'Не найдена MX запись указанного адреса',
    'validator_email_default'          => 'Ошибка проверки адреса электронной почты',

    // ValidatorRange
    'validator_range_range'            => 'Список значений ошибочен!',
    'validator_range_not_in'           => 'Указанное значение "%%xValue%%" не содержиться в списке разрешенных значений.',
    'validator_range_in'               => 'Указанное значение "%%xValue%%" содержиться в списке запрещенных значений.',
    'validator_range_default'          => 'Ошибка проверки значения',
    ''                                 => '',


);
