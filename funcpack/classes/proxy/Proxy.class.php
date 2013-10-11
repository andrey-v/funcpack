<?php
/**
 * Файл основного класса дополнительного функционала funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemPony RC 1 от 05.10.13 01:33
 */

/**
 * Свойство, предоставляющее доступ к модулям CMS
 *
 * * * * * Следующие магические свойства указаны для обеспечения автокомплита * * * *
 * @property ModuleACL       acl
 * @property ModuleAdmin     admin
 * @property ModuleBlog      blog
 * @property ModuleComment   comment
 * @property ModuleFavourite favourite
 * @property ModuleGeo       geo
 * @property ModuleNotify    notify
 * @property ModulePage      page
 * @property ModuleSearch    search
 * @property ModuleStream    stream
 * @property ModuleSubscribe subscribe
 * @property ModuleTalk      talk
 * @property ModuleTools     tools
 * @property ModuleTopic     topic Модуль для работы с топиками
 * @property ModuleUser      user
 * @property ModuleUserfeed  userfeed
 * @property ModuleVote      vote
 * @property ModuleWall      wall
 */
class modules {
    private $sPluginName = "";

    public function __construct($sPluginName = "") {
        $this->sPluginName = 'Plugin' . ucwords($sPluginName) . '_';
    }

    public function __get($sName) {
        return Engine::getInstance()->getModule(
            (($this->sPluginName == 'Plugin_') ? '' : $this->sPluginName) . ucwords($sName) . '_')[0];
    }
}

/**
 * Class, обеспечивающий взаимодействие с методами плагина
 */
class plugins {
    private $modules;

    public function __get($sName) {
        $this->modules = new modules($sName);
        return $this;
    }
}

/**
 * Класс проксирования методов
 */
class Proxy extends E {
    public $modules;

    public $plugins;

    public function __construct() {
        $this->modules = new modules();
        $this->plugins = new plugins();
    }
}

/**
 * Алиас класса проксирования методов
 */
class P extends Proxy {

}
