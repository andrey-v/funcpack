<?php
/**
 * Файл валидатора ValidatorCompare
 * ValidatorCompare сравнивает два значения. Значения могут сравниваться строго - {@link strict}, или нет. Для
 * валидатора определены следующие спецификаторы
 * <ul>
 * <li>{xRequiredValue}: Необходимое значение с которым сравнивается проверяемое значение.</li>
 * <li>{xValue}: Текущее проверяемое значение.</li>
 * </ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 15.10.13 23:01
 */
class ValidatorCompare extends Validator implements IValidator {
    /**
     * Значение с которым сравнивается текущее
     * @var string
     */
    public $xRequiredValue;
    /**
     * Строгая проверка. В случае Истины проверяется тип и значение. По умолчанию FALSE
     * @var bool
     */
    public $bStrict = FALSE;
    /**
     * Оператор сравнения. По умолчанию '='. Может принимать следующие значения:
     * <ul>
     * <li>'=' или '==': проверяет значение на равенство. Если {@link bStrict} ИСТИНА, то проверяется на раввенство еще
     * и тип этих значений.</li>
     * <li>'!=': проверяет значение на НЕ равенство. Если {@link bStrict} ИСТИНА, то проверяется на НЕ равенство еще
     * и по типу этих значений.</li>
     * <li>'>': проверка на больше</li>
     * <li>'>=': проверка на больше или равно</li>
     * <li>'<': проверка на меньше</li>
     * <li>'<=': проверка на меньше или равно</li>
     * </ul>
     * @var string
     */
    public $sOperator = '=';
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
        'operator' => 'sOperator',
        'required' => 'xRequiredValue',
        'strict'   => 'bStrict',
        'empty'    => 'bAllowEmpty',
    ];

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        /** @var array $aMsqParams Массив параметров, передаваемый в текстовку */
        $aMsqParams = [
            'xValue'         => $this->xValue,
            'xRequiredValue' => $this->xRequiredValue
        ];

        switch ($this->sOperator) {
            case '=':
            case '==':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_eq', $aMsqParams);
            case '!=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_not_eq', $aMsqParams);
            case '>':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_rt', $aMsqParams);
            case '>=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_rt_eq', $aMsqParams);
            case '<':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_lt', $aMsqParams);
            case '<=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_lt_eq', $aMsqParams);
            default :
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_compare_default', ['sOperator' => $this->sOperator]);
        }
    }

    /**
     * Проверка текущего значения
     * @throws Exception
     * @return bool
     */
    public function validate() {
        // Получили пустое значение и оно разрешено
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        /** @var bool $bResult Результат валидации */
        $bResult = TRUE;

        // Другие варианты
        switch ($this->sOperator) {
            case '=':
            case '==':
                if (($this->bStrict && $this->xValue !== $this->xRequiredValue) || (!$this->bStrict && $this->xValue != $this->xRequiredValue))
                    $bResult = FALSE;
                break;
            case '!=':
                if (($this->bStrict && $this->xValue === $this->xRequiredValue) || (!$this->bStrict && $this->xValue == $this->xRequiredValue))
                    $bResult = FALSE;
                break;
            case '>':
                if ($this->xValue <= $this->xRequiredValue)
                    $bResult = FALSE;
                break;
            case '>=':
                if ($this->xValue < $this->xRequiredValue)
                    $bResult = FALSE;
                break;
            case '<':
                if ($this->xValue >= $this->xRequiredValue)
                    $bResult = FALSE;
                break;
            case '<=':
                if ($this->xValue > $this->xRequiredValue)
                    $bResult = FALSE;
                break;
            default:
                throw new Exception($this->getMessage());
        }

        if (!$bResult) {
            $this->addError();
            return FALSE;
        }

        return TRUE;
    }

}