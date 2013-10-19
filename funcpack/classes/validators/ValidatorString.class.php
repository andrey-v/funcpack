<?php
/**
 * Файл валидатора ValidatorString
 * ValidatorString проверяет строку на соответствие указанной длине.
 * <br><br>
 * Для валидатора определены следующие модификаторы:
 * <ul>
 *      <li><b>min</b>: Минимальная длина, по умолчанию установлена в NULL - это означает, что минимум для длины строки не установлен.</li>
 *      <li><b>max</b>: Максимальная длина, по умолчанию установлена в NULL - это означает, что максимум для длины строки не установлен.</li>
 *      <li><b>length</b>: Значение длины строки, подразумевающее точное совпадение с проверяемой строкой.</li>
 *      <li><b>empty</b>: разрешать ли пустые значения (по умолчанию TRUE)</li>
 *      <li><b>message</b>: сообщение, которое будет вызвано при ошибке валидации, если не указано, то выведется сообщение по
 *      умолчанию</li>
 *      <li><b>value</b>: проверяемая строка.</li>
 *</ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 16.10.13 14:44
 */
class ValidatorString extends Validator implements IValidator {
    /**
     * Максимальная длина, по умолчанию установлена в NULL - это означает, что максимум для длины строки не установлен.
     * @var integer
     */
    public $iMax;
    /**
     * Минимальная длина, по умолчанию установлена в NULL - это означает, что минимум для длины строки не установлен.
     * @var integer
     */
    public $iMin;
    /**
     * Значение длины строки, подразумевающее точное совпадение с проверяемой строкой.
     * @var integer
     */
    public $iLength;
    /**
     * Разрешать ли пустое значение. Если значение пустое, и это свойство ИСТИНА - то значение будет валидным. По
     * умолчанию FALSE
     * @var bool
     */
    public $bAllowEmpty = FALSE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'min'    => 'iMin',
        'max'    => 'iMax',
        'length' => 'iLength',
        'empty'  => 'bAllowEmpty',
    ];

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        /** @var array $aMsqParams Массив параметров, передаваемый в текстовку */
        $aMsqParams = [
            'xValue'  => $this->xValue,
            'iMin'    => $this->iMin,
            'iMax'    => $this->iMax,
            'iLength' => $this->iLength,
        ];

        if (!is_string($this->xValue))
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_format', $aMsqParams);
        if ($this->iMin !== NULL && $this->iMax !== NULL)
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_range', $aMsqParams);
        if ($this->iMin !== NULL)
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_min', $aMsqParams);
        if ($this->iMax !== NULL)
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_max', $aMsqParams);
        if ($this->iLength !== NULL)
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_length', $aMsqParams);

        return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_string_default', $aMsqParams);
    }

    /**
     * Проверка текущего значения
     * @return bool
     */
    public function validate() {
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        if (!is_string($this->xValue)) {
            $this->addError();
            return FALSE;
        }

        /** @var int $length Длина строки */
        $length = mb_strlen($this->xValue, 'utf-8');

        if (($this->iMin !== NULL && $length < $this->iMin) ||
            ($this->iMax !== NULL && $length > $this->iMax) ||
            ($this->iLength !== NULL && $length !== $this->iLength)
        ) {
            $this->addError();
            return FALSE;
        }

        return TRUE;
    }

}