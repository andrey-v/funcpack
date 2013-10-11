<?php
/**
 * Фабрика всех валидаторов
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemPony RC 1 от 11.10.13 20:04
 */
class FactoryValidator {
    /**
     * Список используемых валидаторов
     * @var array
     */
    private $_aValidatorList = [
        'bool'    => 'ValidatorBoolean',
        'boolean' => 'ValidatorBoolean',
        'url'     => 'ValidatorUrl',
    ];
    /**
     * Текущий экземпляр главного класса валидаторов.
     * @var FactoryValidator
     */
    static protected $oInstance = NULL;

    /**
     * Ограничиваем объект только одним экземпляром.
     * @return FactoryValidator
     */
    static public function getInstance() {
        if (isset(self::$oInstance) && (self::$oInstance instanceof self)) {
            return self::$oInstance;
        } else {
            self::$oInstance = new self();
            return self::$oInstance;
        }
    }

    /**
     * Возвращает массив валидаторов и имен их классов
     * @return array
     */
    final public function getValidatorsList() {
        return $this->_aValidatorList;
    }

    /**
     * Возвращает нужный валидатор, в соответствии с переданными настройками
     * @param $aValidatorSettings Настройки валидатора
     * @return FactoryValidator|null
     */
    final public function getValidator($aValidatorSettings) {
        // Существует ли имя валидатора
        if (!isset($aValidatorSettings[0])) {
            return NULL;
        }

        // Существует ли валидатор в списке классов
        if (!isset($this->getValidatorsList()[$aValidatorSettings[0]])) {
            return NULL;
        }

        // Существует ли файл валидатора, если да, то подключим его
        /** @var string $sClassName Имя класса текущего валидатора */
        $sClassName = $this->getValidatorsList()[$aValidatorSettings[0]];
        /** @var string $sFileName Имя текущего файла валидатора */
        $sFileName = dirname(__FILE__) . '/' . $sClassName . '.class.php';
        if (!file_exists($sFileName)) {
            return NULL;
        }
        /** @noinspection PhpIncludeInspection */
        include_once $sFileName;

        // Создадим валидатор
        /** @var Validator $oValidator Валидатор данного значения */
        $oValidator = new $sClassName;
        if (!$oValidator) {
            return NULL;
        }

        // Заполняем свойства валидатора
        /** @var string $sModifierName Имя текущего свойства валидатора */
        /** @var mixed $xPropertyValue Имя текущего свойства валидатора */
        foreach ($aValidatorSettings as $sModifierName => $xPropertyValue) {
            // Пропустим имя валидатора в списке настроек
            if (!$sModifierName) {
                continue;
            }
            // Известен ли модификатор
            /** @var array $aModifier Массив модификаторов текущего валидатора */
            $aModifier = $oValidator->getModifiers();
            if (!isset($aModifier[$sModifierName])) {
                continue;
            }

            // Установим свойство объекта, если имя свойства корректно
            /** @var string $sPropertyName Имя текущего свойства валидатора */
            $sPropertyName = $aModifier[$sModifierName];
            if (property_exists($sClassName, $sPropertyName)) {
                $oValidator->$sPropertyName = $xPropertyValue;
            }
        }

        // Вернем валидатор
        return $oValidator;
    }
}