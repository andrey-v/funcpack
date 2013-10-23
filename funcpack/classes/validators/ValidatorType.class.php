<?php
/**
 * Файл валидатора ValidatorType
 * ValidatorType проверяет текущее значение на соответствие типу {@link type}.
 * <br><br>
 * Поддерживаются следующие типы:
 * <ul>
 *      <li><b>integer</b>: знаковое целое.</li>
 *      <li><b>float</b>: вещественный тип.</li>
 *      <li><b>string</b>: строковый тип.</li>
 *      <li><b>array</b>: массив </li>
 *      <li><b>date</b>: дата</li>
 *      <li><b>time</b>: время</li>
 *      <li><b>datetime</b>: дата-время</li>
 * </ul>
 *
 * Для даты должен быть определн формат проверки, так как он указан в {@link CDateValidator}, по умолчанию 'dd.MM.yyyy'
 * <br><br>
 * Для валидатора используются следующие модификаторы:
 * <ul>
 *      <li><b>type</b>: тип, на совпадение с которым проверяется значение (см. список типов выше)</li>
 *      <li><b>dateFormat</b>: формат даты, которому должно соответствовать проверяемое значение, по дефолту = 'dd.MM.yyyy'.</li>
 *      <li><b>timeFormat</b>: формат даты, которому должно соответствовать проверяемое значение. по дефолту = 'hh:mm'.</li>
 *      <li><b>dateTimeFormat</b>: формат даты, которому должно соответствовать проверяемое значение, по дефолту = 'dd.MM.yyyy hh:mm'.</li>
 *      <li><b>strict</b>: проверять значение по типу или нет (по умолчанию FALSE)</li>
 *      <li><b>empty</b>: разрешать ли пустые значения (по умолчанию FALSE)</li>
 *      <li><b>message</b>: сообщение, которое будет вызвано при ошибке валидации, если не указано, то выведется сообщение по умолчанию</li>
 *      <li><b>value</b>: проверяемое значение</li>
 * </ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemCode RC 1 от 11.10.13 19:25
 */
class ValidatorType extends Validator implements IValidator {
    /**
     * Строка, определяющаяя тип проверяемого значения. Может быть 'string', 'integer', 'float', 'array', 'date',
     * 'time' и 'datetime'. По умолчанию 'string'.
     * @var string
     */
    public $sType = 'string';
    /**
     * Формат даты, с которым происходит сравнение даты. Подефолту = 'dd.MM.yyyy'. Более подробно в
     * описании {@link CDateTimeParser}
     * @var string
     */
    public $sDateFormat = 'dd.MM.yyyy';
    /**
     * Формат даты, с которым происходит сравнение времени. Подефолту = 'hh:mm'. Более подробно в
     * описании {@link CDateTimeParser}
     * @var string
     */
    public $sTimeFormat = 'hh:mm';
    /**
     * Формат даты, с которым происходит сравнение даты-времени. Подефолту = 'hh:mm'. Более подробно в
     * описании {@link CDateTimeParser}
     * @var string
     */
    public $sDateTimeFormat = 'dd.MM.yyyy hh:mm';
    /**
     * Разрешать ли пустое значение. Если значение пустое, и это свойство ИСТИНА - то значение будет валидным. По
     * умолчанию FALSE
     * @var bool
     */
    public $bAllowEmpty = FALSE;
    /**
     * Строгая проверка. В случае Истины проверяется тип и значение. По умолчанию FALSE
     * @var bool
     */
    public $bStrict = FALSE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'type'           => 'sType',
        'dateFormat'     => 'sDateFormat',
        'timeFormat'     => 'sTimeFormat',
        'dateTimeFormat' => 'sDateTimeFormat',
        'strict'         => 'bStrict',
        'empty'          => 'bAllowEmpty',
    ];

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        /** @var array $aMsqParams Массив параметров, передаваемый в текстовку */
        $aMsqParams = [
            'xValue' => $this->xValue,
            'sType'  => $this->sType,
        ];

        return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_type_default', $aMsqParams);

    }

    /**
     * Проверка текущего значения
     * @return bool
     */
    public function validate() {
        /** @var string $sCurrentType Текущий тип, на который будет проверяться значение */
        $sCurrentType = $this->sType === 'float' ? 'double' : $this->sType;
        if ($sCurrentType === gettype($this->xValue))
            return TRUE;
        elseif ($this->bStrict || is_array($this->xValue) || is_object($this->xValue) || is_resource($this->xValue) || is_bool($this->xValue)) {
            $this->addError();
            return FALSE;
        }

        /** @var bool $bResult Результат валидации */
        $bResult = TRUE;

        if ($sCurrentType === 'integer')
            $bResult = (boolean)preg_match('/^[-+]?[0-9]+$/', trim($this->xValue));
        elseif ($sCurrentType === 'double')
            $bResult = (boolean)preg_match('/^[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?$/', trim($this->xValue));
        elseif ($sCurrentType === 'date')
            $bResult = (boolean)CDateTimeParser::parse($this->xValue, $this->sDateFormat, array('month' => 1, 'day' => 1, 'hour' => 0, 'minute' => 0, 'second' => 0));
        elseif ($sCurrentType === 'time'){
            $bResult = (boolean)CDateTimeParser::parse($this->xValue, $this->sTimeFormat);
        }
        elseif ($sCurrentType === 'datetime')
            $bResult = (boolean)CDateTimeParser::parse($this->xValue, $this->sDateTimeFormat, array('month' => 1, 'day' => 1, 'hour' => 0, 'minute' => 0, 'second' => 0));

        if (!$bResult) {
            $this->addError();
            return FALSE;
        }

        return TRUE;
    }
}