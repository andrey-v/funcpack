<?php
/**
 * Родительский класс для всех валидаторов
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @method Validator validate
 *
 * @version     ProblemPony RC 1 от 11.10.13 20:04
 */
abstract class Validator {
    /**
     * Сообщение, выдаваемое при ошибке валидации
     * @var string
     */
    public $sMessage = '';
    /**
     * Проверяемое значение
     * @var mixed
     */
    public $xValue = NULL;
    /**
     * Массив дефолтных модификаторов и соответствий их свойствам объекта
     * @var array
     */
    private $_aDefaultModifier = [
        'message' => 'sMessage',
        'value'   => 'xValue',
    ];
    /**
     * Массив  модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [];
    /**
     * Код ошибки
     * @var null|int
     */
    protected $iErrorCode = NULL;

    /**
     * Геттер для текста сообщения
     * @return string
     */
    public function getMessage() {
        return $this->sMessage;
    }

    /**
     * Возврашает список доступных модификаторов для валидатора
     * @return array
     */
    final public function getModifiers() {
        return array_merge($this->_aDefaultModifier, $this->_aModifier);
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed   $value the value to be checked
     * @param boolean $trim  whether to perform trimming before checking if the string is empty. Defaults to true.
     * @return boolean whether the value is empty
     */
    final protected function isEmpty($value, $trim = TRUE) {
        return $value === NULL || $value === array() || $value === '' || $trim && is_scalar($value) && trim($value) === '';
    }

    /**
     * Добавление ошибки
     */
    protected function addError() {
        P::modules()->message->AddErrorSingle($this->getMessage(), P::modules()->lang->Get('error'));
    }

}