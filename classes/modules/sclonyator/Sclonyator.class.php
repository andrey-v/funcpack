<?php
/**
 * Файл модуля склонения слов
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2012, Андрей Г. Воронов
 *              Является частью плагина FuncPack
 * @version     1.0 от 26.11.13 22:25
 */
class PluginFuncpack_ModuleSclonyator extends Module {
    /**
     * Маппер
     * @var PluginFuncpack_ModuleSclonyator_MapperSclonyator
     */
    protected $oMapper;

    /**
     * Инициализация модуля
     */
    public function Init() {
        // Получение мапперов
        $this->oMapper = Engine::GetMapper('PluginFuncpack_ModuleSclonyator', 'Sclonyator');
    }

    /**
     * Метод склонения
     * @param string $sText Текст склоения
     * @param int $iPagezh  (Кто? Что? — 1, Кого? Чего? — 2, Кому? Чему? — 3, Кого? Что? — 4, Кем? Чем?— 5, О ком? О чем?— 6).
     * @return string
     */
    public function Sclonenie($sText, $iPagezh) {
        if (!(is_int($iPagezh) && $iPagezh>=1 && $iPagezh<=6)) {
            return $sText;
        }

        if (Config::Get('plugin.funcpack.sclonyator_mode') == 'only_ya') {
            $aData = $this->SclonyatorYaOnly($sText);
            if (count($aData) != 6) {
                return $sText;
            }
            return (string)$aData[$iPagezh-1];
        }

        if (Config::Get('plugin.funcpack.sclonyator_mode') == 'both') {
            if ($sResult = $this->oMapper->GetSclonenie($sText, $iPagezh)) {
                return $sResult;
            }

            $aData = $this->SclonyatorYaOnly($sText);
            if (count($aData) != 6) {
                return $sText;
            }
            /** @var PluginFuncpack_ModuleSclonyator_EntitySclonyator $oSclonenie */
            $oSclonenie = Engine::GetEntity('PluginFuncpack_ModuleSclonyator_EntitySclonyator', array(
               'sclonenie_P1' => (string)$aData[0],
               'sclonenie_P2' => (string)$aData[1],
               'sclonenie_P3' => (string)$aData[2],
               'sclonenie_P4' => (string)$aData[3],
               'sclonenie_P5' => (string)$aData[4],
               'sclonenie_P6' => (string)$aData[5],
            ));
            $this->oMapper->CreateSclonenie($oSclonenie);
            return $aData[$iPagezh-1];
        }
        if (Config::Get('plugin.funcpack.sclonyator_mode') == 'only_bd') {
            if ($sResult = $this->oMapper->GetSclonenie($sText, $iPagezh)) {
                return $sResult;
            }
        }

        return $sText;
    }

    /**
     * Получает массив склонений от Яндекса
     * @param string $sText
     * @return SimpleXMLElement[]|string
     */
    private function SclonyatorYaOnly($sText = '') {
        if (!empty($sText)) {
            $xml = @simplexml_load_file("http://export.yandex.ru/inflect.xml?name=" . $sText);
            if ($xml) {
                return $xml->inflection;
            }
        }
        return $sText;
    }

}