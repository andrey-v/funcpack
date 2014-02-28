<?php
/**
 * Файл валидатора ValidatorRange
 * ValidatorRange проверяет вхождение значения в список допустимых значений.
 * <br><br>
 * Для валидатора определены следующие модификаторы:
 * <ul>
 *      <li><b>range</b>: Массив допустимых значений</li>
 *      <li><b>strict</b>: Строгая проверка. В случае Истины проверяется тип и значение. По умолчанию FALSE</li>
 *      <li><b>empty</b>: разрешать ли пустые значения (по умолчанию TRUE)</li>
 *      <li><b>not</b>: Инвертор логики проверки. в случае значения TRUE проверка осуществляется на НЕ вхождение в запрещенный список. </li>
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
 * @version     ProblemCode RC 1 от 19.10.13 00:39
 */
class ValidatorRange extends Validator implements IValidator {
    /**
     * Массив допустимых значений
     * @var array
     */
    public $aRange;
    /**
     * Строгая проверка. В случае Истины проверяется тип и значение. По умолчанию FALSE
     * @var bool
     */
    public $bStrict = FALSE;
    /**
     * Разрешать ли пустое значение. Если значение пустое, и это свойство ИСТИНА - то значение будет валидным. По
     * умолчанию FALSE
     * @var bool
     */
    public $bAllowEmpty = FALSE;
    /**
     * Инвертор логики проверки. в случае значения TRUE проверка осуществляется на НЕ вхождение в запрещенный список.
     * @var boolean
     **/
    public $bNot = FALSE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'range'  => 'aRange',
        'strict' => 'bStrict',
        'empty'  => 'bAllowEmpty',
        'not'    => 'bNot',
    ];

    /**
     * Спиок значений ошибочный
     */
    const ERROR_CODE_RANGE = 0;
    /**
     * Значение не в списке
     */
    const ERROR_CODE_NOT_IN_RANGE = 1;
    /**
     * Значение в списке
     */
    const ERROR_CODE_IN_RANGE = 2;

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        /** @var array $aMsqParams Массив параметров, передаваемый в текстовку */
        $aMsqParams = [
            'xValue' => $this->xValue,
        ];

        switch ($this->iErrorCode) {
            case self::ERROR_CODE_RANGE:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_range_range', $aMsqParams);
            case self::ERROR_CODE_NOT_IN_RANGE:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_range_not_in', $aMsqParams);
            case self::ERROR_CODE_IN_RANGE:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_range_in', $aMsqParams);
            default :
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_range_default', $aMsqParams);
        }
    }

    /**
     * Проверка текущего значения
     * @return bool
     * @throws Exception
     */
    public function validate() {
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        if (!is_array($this->aRange)) {
            $this->iErrorCode = self::ERROR_CODE_RANGE;
            $bResult = FALSE;
        } else {
            $bResult = FALSE;
            if ($this->bStrict)
                $bResult = in_array($this->xValue, $this->aRange, TRUE);
            else {
                foreach ($this->aRange as $r) {
                    $bResult = (strcmp($r, $this->xValue) === 0);
                    if ($bResult)
                        break;
                }
            }
            if (!$this->bNot && !$bResult) {
                $this->iErrorCode = self::ERROR_CODE_NOT_IN_RANGE;
            } elseif ($this->bNot && $bResult) {
                $this->iErrorCode = self::ERROR_CODE_IN_RANGE;
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