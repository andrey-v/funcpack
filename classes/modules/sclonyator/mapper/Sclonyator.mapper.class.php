<?php
/**
 * Файл маппера склонений
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funckPack
 * @property DbSimple_Generic_Database $oDb
 * @version     1.0 от 26.11.13 22:26
 */
class PluginFuncpack_ModuleSclonyator_MapperSclonyator extends Mapper {

    /**
     * Добавление склонения
     * @param PluginFuncpack_ModuleSclonyator_EntitySclonyator $oSclonenie
     * @return boolean|int
     */
    public function CreateSclonenie($oSclonenie) {
        $sql = "INSERT INTO " . Config::Get('db.table.funcpack_sclonenie') . "
        (
            sclonenie_P1,
            sclonenie_P2,
            sclonenie_P3,
            sclonenie_P4,
            sclonenie_P5,
            sclonenie_P6
        )
            VALUES
        (?, ?, ?, ?, ?, ?)
		";
        if ($iId = $this->oDb->query($sql,
            $oSclonenie->getP1(),
            $oSclonenie->getP2(),
            $oSclonenie->getP3(),
            $oSclonenie->getP4(),
            $oSclonenie->getP5(),
            $oSclonenie->getP6())
        ) {
            return $iId;
        }

        return FALSE;
    }

    /**
     * Проверка существования связи
     * @param int $iPagezh
     * @param string $sText
     * @return boolean|int
     */
    public function GetSclonenie($sText, $iPagezh) {
        if (!(is_int($iPagezh) && $iPagezh>=1 && $iPagezh<=6)) {
            return $sText;
        }

        $sText = trim($sText);

        $sql = "SELECT
                    `sclonenie_P" . $iPagezh . "` as text
                FROM
                    " . Config::Get('db.table.funcpack_sclonenie') . "
                WHERE
                    `sclonenie_P1` LIKE ?
                    OR `sclonenie_P2` LIKE ?
                    OR `sclonenie_P3` LIKE ?
                    OR `sclonenie_P4` LIKE ?
                    OR `sclonenie_P5` LIKE ?
                    OR `sclonenie_P6` LIKE ?";
        if ($aRow = $this->oDb->selectRow($sql, $sText, $sText, $sText, $sText, $sText, $sText)) {
            return $aRow['text'];
        }
        return FALSE;
    }

}