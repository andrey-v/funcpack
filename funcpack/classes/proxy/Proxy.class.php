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
 * @property ModuleACL         acl
 * @property ModuleAdmin       admin
 * @property ModuleBlog        blog
 * @property ModuleComment     comment
 * @property ModuleFavourite   favourite
 * @property ModuleGeo         geo
 * @property ModuleNotify      notify
 * @property ModulePage        page
 * @property ModuleSearch      search
 * @property ModuleStream      stream
 * @property ModuleSubscribe   subscribe
 * @property ModuleTalk        talk
 * @property ModuleTools       tools
 * @property ModuleTopic       topic Модуль для работы с топиками
 * @property ModuleUser        user
 * @property ModuleUserfeed    userfeed
 * @property ModuleVote        vote
 * @property ModuleWall        wall
 * @property ModuleCache       cache
 * @property ModuleDatabase    database
 * @property ModuleHook        hook
 * @property ModuleImage       image
 * @property ModuleImg         img
 * @property ModuleLang        lang
 * @property ModuleLess        less
 * @property ModuleLogger      logger
 * @property ModuleMail        mail
 * @property ModuleMessage     message
 * @property ModulePlugin      plugin
 * @property ModuleRequest     request
 * @property ModuleSecurity    security
 * @property ModuleSession     session
 * @property ModuleSkin        skin
 * @property ModuleText        text
 * @property ModuleValidate    validate
 * @property ModuleViewer      viewer   Модуль обработки шаблонов используя шаблонизатор Smarty
 * @property ModuleViewerAsset viewerAssert
 * @property ModuleWidget      widget
 *
 */
class Modules {
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
class Plugins {
    private $modules;

    public function __get($sName) {
        $this->modules = new modules($sName);
        return $this;
    }
}

/**
 * Класс проксирования методов
 */
class Proxy extends LsObject {
    /**
     * Предоставляет доступ к модулям CMS
     * @return Modules modules
     */
    final public static function modules() {
        return new Modules();
    }

    /**
     * Предоставляет доступ к модулям плагина CMS
     * @return Plugins
     */
    final public static function plugins() {
        return new Plugins();
    }
}

