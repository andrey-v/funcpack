<?php
/**
 * Примесь, реализующая выполнение стандартного функционала плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 11.10.13 10:12
 */
trait AdvancedPlugin {

    public function initScripts() {
        P::modules()->viewer->AppendStyle(Plugin::GetTemplatePath(__CLASS__) . "css/style.css"); // Добавление CSS
        P::modules()->viewer->AppendScript(Plugin::GetTemplatePath(__CLASS__) . "js/script.js"); // Добавление JS
    }

}
