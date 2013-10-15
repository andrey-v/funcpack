<?php
/**
 * Файл валидатора ValidatorBoolean
 * ValidatorBoolean проверяет текущее значение на соответствие значениям {@link xTrueValue} или {@link xFalseValue},
 * указанным в соответствующих атрибутах. То есть проверяемое значение должно быть либо истинным, либо ложным, причем
 * возможна строгая проверка вместе с соответствием типа, возможность устанавливается свойством {@link bStrict}.
 * <br><br>
 * В случае возникновения ошибки валидатор возвращает значение FALSE. Если для валидатор установлено сообщение, то оно
 * будет выведено методом AddErrorSingle модуля {@link Message}.
 * Для валидатора используются следующие модификаторы:
 * <ul>
 * <li><b>true</b>: значение, которое считается истинным, устанавивает свойство {@link xTrueValue} (по умолчанию 1)</li>
 * <li><b>false</b>: значение, которое считается ложным, устанавивает свойство {@link xFalseValue} (по умолчанию 0)</li>
 * <li><b>strict</b>: проверять значение по типу или нет (по умолчанию FALSE)</li>
 * <li><b>empty</b>: разрешать ли пустые значения (по умолчанию TRUE)</li>
 * </ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 11.10.13 19:25
 */
class ValidatorBoolean extends Validator implements IValidator {
    /**
     * Определяет истинное значение, по умолчанию '1'.
     * @var mixed
     */
    public $xTrueValue = '1';
    /**
     * Определяет ложное значение, по умолчанию '0'.
     * @var mixed
     */
    public $xFalseValue = '0';
    /**
     * Устанавливает тип строгого сравнения проверяемого значения со значениями {@link xTrueValue} или
     * {@link xFalseValue} если это значение установлено в TRUE, то проверка на соответствие проводиться по типу и по
     * значению. Поумолчанию FALSE. Это значит, что проверка будет проверятся только на соответствие значению.
     * @var bool
     */
    public $bStrict = FALSE;
    /**
     * Может ли атрибут быть пустым. Если значение установлено в TRUE, то пустое валидируемое значение пройдет проверку,
     * Иначе, пройдет проверку только в случае соответствия {@link xTrueValue}
     * @var boolean
     */
    public $bAllowEmpty = TRUE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'true'   => 'xTrueValue',
        'false'  => 'xFalseValue',
        'strict' => 'bStrict',
        'empty'  => 'bAllowEmpty',
    ];

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if (!$this->sMessage)
            $this->sMessage = P::modules()->lang->Get(
                'plugin.funcpack.validator_default_boolean' . ($this->bStrict ? '_strict' : ''),
                [
                    'xValue'      => $this->xValue,
                    'xTrueValue'  => $this->xTrueValue,
                    'xFalseValue' => $this->xFalseValue,
                ]);

        return $this->sMessage;
    }

    /**
     * Метод валидации значения
     * @return boolean
     */
    final public function validate() {
        // Значение пустое и его разрешено принимать как верное
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        // Основной блок проверки
        if (!$this->bStrict && $this->xValue != $this->xTrueValue && $this->xValue != $this->xFalseValue
            || $this->bStrict && $this->xValue !== $this->xTrueValue && $this->xValue !== $this->xFalseValue
        ) {
            $this->addError();
            return FALSE;
        }

        // Проверка пройдена, все ОК
        return TRUE;
    }

}