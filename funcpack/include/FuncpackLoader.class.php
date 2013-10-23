<?php
/**
 * Автолоадер плагина funcPack
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 11.10.13 10:47
 */
class FuncpackLoader extends LsObject {

    function __construct() {
        /** Подключим класс проксирования методов */
        include_once dirname(__FILE__) . '/../classes/proxy/Proxy.class.php';

        /** Подключим основной класс хелпера */
        include_once dirname(__FILE__) . '/../classes/p/P.class.php';

        /** Подключение примесей */
        include_once dirname(__FILE__) . '/../classes/traits/AdvancedPlugin.trait.php';
        include_once dirname(__FILE__) . '/../classes/traits/AdvancedHook.trait.php';

        /** Подключим валидаторы */
        include_once dirname(__FILE__) . '/../classes/validators/Validator.interface.php';
        include_once dirname(__FILE__) . '/../classes/validators/Validator.factory.php';
        include_once dirname(__FILE__) . '/../classes/validators/Validator.class.php';

    }
}

new FuncpackLoader();