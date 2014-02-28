<?php
/**
 * Файл сущности склонений
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     1.0 от 26.11.13 22:28
 */
class PluginFuncpack_ModuleSclonyator_EntitySclonyator extends Entity {

    public function getId() { return $this->_aData['sclonenie_id']; }
    public function getP1() { return $this->_aData['sclonenie_P1']; }
    public function getP2() { return $this->_aData['sclonenie_P2']; }
    public function getP3() { return $this->_aData['sclonenie_P3']; }
    public function getP4() { return $this->_aData['sclonenie_P4']; }
    public function getP5() { return $this->_aData['sclonenie_P5']; }
    public function getP6() { return $this->_aData['sclonenie_P6']; }

    public function setP1($data) { $this->_aData['sclonenie_P1'] = $data; }
    public function setP2($data) { $this->_aData['sclonenie_P2'] = $data; }
    public function setP3($data) { $this->_aData['sclonenie_P3'] = $data; }
    public function setP4($data) { $this->_aData['sclonenie_P4'] = $data; }
    public function setP5($data) { $this->_aData['sclonenie_P5'] = $data; }
    public function setP6($data) { $this->_aData['sclonenie_P6'] = $data; }

}