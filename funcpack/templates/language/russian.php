<?php
/**
 * Файл локализации для русского языка плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemPony RC 1 от 05.10.13 01:37
 */
return array(
    // Описание ядра пакета
    'core_version_name'                => 'ProblemPony RC 1',
    'core_version_date'                => '12 октября 2013 года',
    '',

    // Валидаторы значений
    'validator_default_boolean_strict' => 'Указанное значение "%%xValue%%" не является правильным, значение должно быть равно либо "%%xTrueValue%%" либо "%%xFalseValue%%", в том числе по типу',
    'validator_default_boolean'        => 'Указанное значение "%%xValue%%" не является правильным, значение должно быть равно "%%xTrueValue%%" или "%%xFalseValue%%", либо приводиться к ним по типу',

    'validator_default_url'            => 'Указанное значение "%%xValue%%" не является правильным url-адресом.',

    'validator_compare_eq'             => 'Значение %%xValue%% и значение %%xRequiredValue%% должны быть равны.',
    'validator_compare_not_eq'         => 'Значение %%xValue%% и значение %%xRequiredValue%% НЕ должны быть равны.',
    'validator_compare_rt'             => 'Значение %%xValue%% должно быть больше значения %%xRequiredValue%%.',
    'validator_compare_rt_eq'          => 'Значение %%xValue%% должно быть больше либо равно значению %%xRequiredValue%%.',
    'validator_compare_lt'             => 'Значение %%xValue%% должно быть меньше значения %%xRequiredValue%%.',
    'validator_compare_lt_eq'          => 'Значение %%xValue%% должно быть меньше либо равно значению %%xRequiredValue%%.',
    'validator_compare_default'        => 'Ошибочное значение оператора %%sOperator%%',

    'validator_date_eq'                => 'Дата %%xValue%% и дата %%xRequiredValue%% должны быть равны.',
    'validator_date_not_eq'            => 'Дата %%xValue%% и дата %%xRequiredValue%% НЕ должны быть равны.',
    'validator_date_rt'                => 'Дата %%xValue%% должны быть больше даты %%xRequiredValue%%.',
    'validator_date_rt_eq'             => 'Дата %%xValue%% должны быть больше либо равно дате %%xRequiredValue%%.',
    'validator_date_lt'                => 'Дата %%xValue%% должны быть меньше даты %%xRequiredValue%%.',
    'validator_date_lt_eq'             => 'Дата %%xValue%% должны быть меньше либо равно дате %%xRequiredValue%%.',
    'validator_date_default'           => 'Ошибочное значение оператора %%sOperator%%',
    'validator_date_format'            => 'Формат даты %%xValue%% ошибочен. Формат должен быть такой: "%%sFormat%%"',
    'validator_date_format_required'   => 'Формат требуемой даты %%xValue%% ошибочен. Формат должен быть такой: "%%sFormat%%"',

    'validator_type_default'           => 'Тип значения "%%xValue%%" не соответствует типу "%%sType%%"',
    ''                                 => '',
);
