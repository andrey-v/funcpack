<?php
/**
 * Файл валидатора ValidatorNumber
 * ValidatorNumber проверяет число на больше-меньше или на вхождение в диапазон.
 * <br><br>
 * Для валидатора определены следующие модификаторы:
 * <ul>
 *      <li><b>min</b>: Минимальная величина, по умолчанию установлена в NULL - это означает, что минимум для числа не установлен.</li>
 *      <li><b>max</b>: Максимальная величина, по умолчанию установлена в NULL - это означает, что максимум числа не установлен.</li>
 *      <li><b>integer</b>: Флаг, указывающий, что проверяются только целочисленные значения, по умолчанию FALSE</li>
 *      <li><b>empty</b>: разрешать ли пустые значения (по умолчанию TRUE)</li>
 *      <li><b>message</b>: сообщение, которое будет вызвано при ошибке валидации, если не указано, то выведется сообщение по
 *      умолчанию</li>
 *      <li><b>value</b>: проверяемое число.</li>
 *</ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 19.10.13 00:39
 */
class ValidatorNumber extends Validator implements IValidator {
    /**
     * Флаг, указывающий, что проверяются только целочисленные значения, по умолчанию FALSE
     * @var boolean
     */
    public $bIntegerOnly = FALSE;
    /**
     * Разрешать ли пустое значение. Если значение пустое, и это свойство ИСТИНА - то значение будет валидным. По
     * умолчанию FALSE
     * @var bool
     */
    public $bAllowEmpty = TRUE;
    /**
     * Максимальная величина, по умолчанию установлена в NULL - это означает, что максимум числа не установлен.
     * @var integer|float
     */
    public $iMax;
    /**
     * Минимальная величина, по умолчанию установлена в NULL - это означает, что минимум для числа не установлен.
     * @var integer|float
     */
    public $iMin;
    /**
     * Регулярка проверки целого числа
     * @var string
     */
    private $integerPattern = '/^\s*[+-]?\d+\s*$/';
    /**
     * Регулярка проверки вещественного числа
     * @var string
     */
    private $numberPattern = '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/';
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'min'     => 'iMin',
        'max'     => 'iMax',
        'integer' => 'bIntegerOnly',
        'empty'   => 'bAllowEmpty',
    ];
    /**
     * Неизвестная ошибка
     */
    const ERROR_CODE_DEFAULT = -1;
    /**
     * Не число
     */
    const ERROR_CODE_NOT_NUMBER = 0;
    /**
     * Не целое
     */
    const ERROR_CODE_NOT_INTEGER = 1;
    /**
     * Значение меньще минимального
     */
    const ERROR_CODE_TOO_SMALL = 2;
    /**
     * Значение больше максимального
     */
    const ERROR_CODE_TOO_BIG = 3;

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        /** @var array $aMsqParams Массив параметров, передаваемый в текстовку */
        $aMsqParams = [
            'xValue'       => $this->xValue,
            'iMin'         => $this->iMin,
            'iMax'         => $this->iMax,
            'bIntegerOnly' => $this->bIntegerOnly,
        ];

        switch ($this->iErrorCode) {
            case self::ERROR_CODE_NOT_NUMBER:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_number_number', $aMsqParams);
            case self::ERROR_CODE_NOT_INTEGER:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_number_integer', $aMsqParams);
            case self::ERROR_CODE_TOO_SMALL:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_number_to_small', $aMsqParams);
            case self::ERROR_CODE_TOO_BIG:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_number_to_big', $aMsqParams);
            default :
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_number_default', $aMsqParams);
        }
    }

    /**
     * Проверка текущего значения
     * @return bool
     */
    public function validate() {
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        /** @var bool $bResult Результат валидации */
        $bResult = TRUE;

        if (!is_numeric($this->xValue)) {
            $this->iErrorCode = self::ERROR_CODE_NOT_NUMBER;
            $bResult = FALSE;
        } else {
            if ($this->bIntegerOnly) {
                if (!preg_match($this->integerPattern, "$this->xValue")) {
                    $this->iErrorCode = self::ERROR_CODE_NOT_INTEGER;
                    $bResult = FALSE;
                }
            } else {
                if (!preg_match($this->numberPattern, "$this->xValue")) {
                    $this->iErrorCode = self::ERROR_CODE_NOT_NUMBER;
                    $bResult = FALSE;
                }
            }
            if ($this->iMin !== NULL && $this->xValue < $this->iMin) {
                $this->iErrorCode = self::ERROR_CODE_TOO_SMALL;
                $bResult = FALSE;
            }
            if ($this->iMax !== NULL && $this->xValue > $this->iMax) {
                $this->iErrorCode = self::ERROR_CODE_TOO_BIG;
                $bResult = FALSE;
            }
        }

        if (!$bResult) {
            $this->addError();
            return FALSE;
        }
        return TRUE;

    }

}