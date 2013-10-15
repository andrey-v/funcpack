<?php
/**
 * Файл валидатора ValidatorDate
 * ValidatorCompare сравнивает дату (время или datetime) на соответствие формату, а также сравнивает даты на
 * больше-меньше-равно.
 * <ul>
 * <li>{xRequiredValue}: Необходимое значение с которым сравнивается проверяемое значение.</li>
 * <li>{xValue}: Текущее проверяемое значение даты.</li>
 * </ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 16.10.13 00:17
 */
class ValidatorDate extends Validator implements IValidator {
    /**
     * Штамп времени требуемого значения
     * @var int|bool
     */
    private $timeStampValueRequired = FALSE;
    /**
     * Штамп времени проверяемого значения
     * @var int|bool
     */
    private $timeStampValue = FALSE;
    /**
     * Формат даты, с которым происходит сравнение. Подефолту = 'dd.MM.yyyy'. Более подробно в
     * описании {@link CDateTimeParser}
     * @var string
     */
    public $sFormat = 'dd.MM.yyyy';
    /**
     * Разрешать ли пустое значение. Если значение пустое, и это свойство ИСТИНА - то значение будет валидным. По
     * умолчанию FALSE
     * @var bool
     */
    public $bAllowEmpty = FALSE;
    /**
     * Значение с которым сравнивается текущее. Может быть пустым, если проверяется только формат даты
     * @var string
     */
    public $xRequiredValue = NULL;
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
    public $sOperation = '=';
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'operation' => 'sOperation',
        'required'  => 'xRequiredValue',
        'empty'     => 'bAllowEmpty',
        'format'    => 'sFormat',
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

        if (!$this->timeStampValue) {
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_format', [
                'xValue'  => $this->xValue,
                'sFormat' => $this->sFormat
            ]);
        }

        if (!$this->timeStampValueRequired) {
            return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_format_required', [
                'xValue'  => $this->xRequiredValue,
                'sFormat' => $this->sFormat
            ]);
        }

        switch ($this->sOperation) {
            case '=':
            case '==':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_eq', $aMsqParams);
            case '!=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_not_eq', $aMsqParams);
            case '>':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_rt', $aMsqParams);
            case '>=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_rt_eq', $aMsqParams);
            case '<':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_lt', $aMsqParams);
            case '<=':
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_lt_eq', $aMsqParams);
            default :
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_date_default', ['sOperator' => $this->sOperation]);
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
        $bResult = FALSE;

        // Проверяем на формат даты
        include_once dirname(__FILE__) . '/../libs/external/yii_utils/CDateTimeParser.php';
        include_once dirname(__FILE__) . '/../libs/external/yii_utils/CTimestamp.php';
        $this->timeStampValue = CDateTimeParser::parse($this->xValue, $this->sFormat);
        if ($this->timeStampValue !== FALSE) {
            $bResult = TRUE;
        }

        // Сравнение дат. если это необходимо, т.е. передана дата для сравнения и дата прошла по формату
        if (!is_null($this->xRequiredValue) && $bResult) {
            // Формат требуемой даты должен быть точно-такой же как и у проверяемой
            $this->timeStampValueRequired = CDateTimeParser::parse($this->xRequiredValue, $this->sFormat);
            if ($this->timeStampValueRequired == FALSE) {
                $bResult = FALSE;
            } else
                // Начнем проверку
                switch ($this->sOperation) {
                    case '=':
                    case '==':
                        if ($this->timeStampValue != $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    case '!=':
                        if ($this->timeStampValue == $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    case '>':
                        if ($this->timeStampValue <= $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    case '>=':
                        if ($this->timeStampValue < $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    case '<':
                        if ($this->timeStampValue >= $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    case '<=':
                        if ($this->timeStampValue > $this->timeStampValueRequired)
                            $bResult = FALSE;
                        break;
                    default:
                        throw new Exception($this->getMessage());
                }
        }

        if (!$bResult) {
            $this->addError();
            return FALSE;
        }

        return TRUE;
    }

}