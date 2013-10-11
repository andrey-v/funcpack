<?php
/** Запрещаем напрямую через браузер обращение к этому файлу.  */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

/**
 * Файл основного класса плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @method void Viewer_AppendStyle
 * @method void Viewer_AppendScript
 * @method void Viewer_Assign
 *
 * @version     ProblemPony RC 1 от 05.10.13 01:33
 */
class PluginFuncpack extends Plugin {

    /** @var array $aDelegates Объявление делегирований */
    protected $aDelegates = [
        'template' => [],
    ];

    /** @var array $aInherits Объявление переопределений (модули, мапперы и сущности) */
    protected $aInherits = [
        'actions' => [],
        'modules' => [],
        'entity'  => [],
    ];

    /**
     * Активация плагина
     * @return bool
     */
    public function Activate() {
        if (!$this->isTableExists('prefix_funcpack_data')) {
            $this->ExportSQL(dirname(__FILE__) . '/install.sql');
        }
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
        P::validate([
            ['boolean', 'value' => TRUE],
            ['url', 'value' => 'http://кто.рф/', 'validSchemes' => array('http'), 'validateIDN' => true],

        ]);

        P::modules()->viewer->Assign("sTemplatePath", Plugin::GetTemplatePath(__CLASS__));
        P::modules()->viewer->AppendStyle(Plugin::GetTemplatePath(__CLASS__) . "css/style.css"); // Добавление CSS
        P::modules()->viewer->AppendScript(Plugin::GetTemplatePath(__CLASS__) . "js/script.js"); // Добавление JS
    }

}
