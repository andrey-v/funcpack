<?php
/**
 * Автолоадер плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemPony RC 1 от 11.10.13 10:47
 */
class FuncpackLoader extends LsObject {

    function __construct() {
        /** Подключим класс проксирования методов */
        include_once dirname(__FILE__) . '/../classes/proxy/Proxy.class.php';

        /** Подключение примесей */
        include_once dirname(__FILE__) . '/../classes/traits/AdvancedPlugin.trait.php';
    }
}

new FuncpackLoader();