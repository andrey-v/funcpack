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
 * @version     ProblemCode RC 1 от 05.10.13 01:33
 */
class PluginFuncpack extends Plugin {

//    use AdvancedPlugin;

    /** @var array $aDelegates Объявление делегирований */
    protected $aDelegates = [
        'template' => [],
        'action' => [
            'ActionCaptcha',
        ],
    ];
    /** @var array $aInherits Объявление переопределений (модули, мапперы и сущности) */
    protected $aInherits = [

        'modules' => [
            'ModuleLang',
        ],
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
//        P::validate([
//            /*  1 */    [FV::BASE_BOOL, 'value' => TRUE],
//            /*  2 */    [FV::BASE_URL, 'value' => 'http://кто.рф/', 'scheme' => array('http', 'https'), 'idn' => TRUE],
//            /*  3 */    [FV::BASE_COMPARE, 'value' => '', 'operator' => '==', 'required' => '10', 'empty' => TRUE, 'strict' => FALSE],
//            /*  4 */    [FV::BASE_DATE, 'value' => date('d.m.Y'), 'format'=>'dd.MM.yyyy', 'required' => '19.10.2013', 'operation' => '<='],
//            /*  5 */    [FV::BASE_TYPE, 'value' => '12:59', 'type' => 'time'],
//            /*  6 */    [FV::BASE_STRING, 'value' => 'hello', 'max' => 5, 'min' => 2],
//            /*  7 */    [FV::BASE_NUMBER, 'value' => 5, 'min' => 3],
//            /*  8 */    [FV::BASE_EMAIL, 'value' => 'andreyv@gladcode.ru', 'mx' => TRUE, 'idn' => TRUE, 'empty' => FALSE],
//            /*  9 */    [FV::BASE_RANGE, 'value' => 5, 'range' => [1, 2, '5', 4, 5], 'not' => FALSE, 'strict' => TRUE, 'empty' => FALSE],
//        ]);


        P::modules()->viewer->Assign("sTemplatePath", Plugin::GetTemplatePath(__CLASS__));

        // Используем примесь
//        $this->initScripts();
//        P::modules()->viewer->AppendScript(Plugin::GetTemplateWebPath(__CLASS__) . 'js/script.js');
    }

}
