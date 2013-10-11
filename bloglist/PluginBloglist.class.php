<?php
/** Запрещаем напрямую через браузер обращение к этому файлу.  */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

/**
 * Файл основного класса плагина blogList
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина blogList
 *
 * @method void Viewer_AppendStyle
 * @method void Viewer_AppendScript
 * @method void Viewer_Assign
 *
 * @version     0.1 от 11.10.13 09:41
 */
class PluginBloglist extends Plugin {

    use AdvancedPlugin;

    /** @var array $aDelegates Объявление делегирований */
    protected $aDelegates = array(
        'template' => array(),
    );

    /** @var array $aInherits Объявление переопределений (модули, мапперы и сущности) */
    protected $aInherits = array(
        'actions' => array(),
        'modules' => array(),
        'entity'  => array(),
    );

    /**
     * Активация плагина
     * @return bool
     */
    public function Activate() {
        return TRUE;
    }

    /**
     * Деактивация плагина
     * @return bool
     */
    public function Deactivate() {
        return TRUE;
    }

    /**
     * Инициализация плагина
     */
    public function Init() {
        P::modules()->viewer->Assign("sTemplatePath", Plugin::GetTemplatePath(__CLASS__));
        P::modules()->viewer->AppendStyle(Plugin::GetTemplatePath(__CLASS__) . "css/style.css"); // Добавление CSS
        P::modules()->viewer->AppendScript(Plugin::GetTemplatePath(__CLASS__) . "js/script.js");
    }
}