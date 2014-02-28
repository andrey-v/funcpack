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
     *
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

    /**
     * Функция перевода строк
     *
     * @param array|string $aParams
     * @return bool|mixed|string
     */
    final public static function Lang($aParams) {

        if (is_string($aParams)) {
            switch ($aParams) {
                case 'error':
                    return P::modules()->lang->Get('error');
                default:
                    $aParams = array('string' => $aParams);
            }
        }

        // Получаем строку
        if (empty($aParams['string'])) {
            trigger_error('Config: missing "string" parameter', E_USER_WARNING);
            return FALSE;
        }

        // Строка должна быть строкой и никак иначе
        if (!is_string($aParams['string'])) {
            trigger_error('Config: parameter "string" must be string type', E_USER_WARNING);
            return FALSE;
        }

        // Возможно в ней будем что-то заменять
        $aReplace = array();
        if (!empty($aParams['replace'])) {
            $aReplace = $aParams['replace'];
        }

        // А может и удалять
        $bDelete = FALSE;
        if (!empty($aParams['delete'])) {
            $bDelete = $aParams['delete'];
        }

        // Получаем текстовку из языкового файла
//    $sResult = Engine::getInstance()->Lang_Get($aParams['string'], $aReplace, $bDelete);

        $sResult = P::modules()->lang->Get($aParams['string'], $aReplace, $bDelete);
        // Если текстовки нет, обработаем ту, что пришла
        if ($sResult == mb_strtoupper($aParams['string'])) {
            $sResult = $aParams['string'];
            $aReplacePairs = array();
            if (is_array($aReplace) && count($aReplace)) {
                foreach ($aReplace as $sFrom => $sTo) {
                    $aReplacePairs["%%{$sFrom}%%"] = $sTo;
                }
                $sResult = strtr($aParams['string'], $aReplacePairs);
            }

            if (Config::Get('module.lang.delete_undefined') && $bDelete) {
                $sResult = preg_replace('|\%\%[\S]+\%\%|U', '', $sResult);
            }
        }

        return $sResult;
    }


    /**
     * Метод склонения
     * @param string $sText Текст склоения
     * @param int $iPagezh  (Кто? Что? — 1, Кого? Чего? — 2, Кому? Чему? — 3, Кого? Что? — 4, Кем? Чем?— 5, О ком? О чем?— 6).
     * @return string
     */
    final public static function L($sText, $iPagezh) {
        return Engine::getInstance()->PluginFuncpack_Sclonyator_Sclonenie($sText, $iPagezh);
    }

}