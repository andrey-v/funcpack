<?php
/**
 * Основной класс хелпера, предоставляемого плагином funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 11.10.13 21:24
 */
class P extends Proxy {
    /**
     * Метод, валидирующий значение
     * @param $aValidatorSetting Массив валидаторов
     * @return bool
     */
    final public static function validate($aValidatorSetting) {
        if (empty($aValidatorSetting)) {
            return TRUE;
        }

        /** @var array $aCurrentValidatorSettings Параметры текущего валидатора */
        foreach ($aValidatorSetting as $aCurrentValidatorSettings) {
            /** @var Validator $oValidator Текущий объект-валидатор */
            $oValidator = FactoryValidator::getInstance()->getValidator($aCurrentValidatorSettings);
            if (!$oValidator->validate()) {
                return FALSE;
            }
        }

        // Все хорошо, не сработал ни один валидатор
        return TRUE;
    }
}