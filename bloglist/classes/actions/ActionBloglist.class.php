<?php
/**
 * Файл экшена blogList плагина blogList
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина blogList
 *
 * @version     0.1 от 05.10.13 09:54
 */
class PluginBloglist_ActionBloglist extends ActionPlugin {
    /**
     * Инициализация экшена
     */
    public function Init() {
        // Установка дефолтного ивента для текущего экшена
        $this->SetDefaultEvent('index');
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() {
        $this->AddEvent('index', 'EventIndex');
    }

    /**
     * Ивент страницы содержания блога
     */
    protected function EventIndex() {

    }

}