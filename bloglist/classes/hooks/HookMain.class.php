<?php
/**
 * Файл хука для плагина blogList
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyrights  Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина blogList
 *
 * @version     0.1 от 05.10.13 09:52
 */
class PluginBloglist_HookMain extends Hook {

    use AdvancedHook;

    /**
     * Регистрация хуков
     */
    public function RegisterHook() {
        // Добавление ссылки на содержание блога в меню блога
        $this->AddHook('template_menu_blog_blog_item', 'blogMenu');
    }

    public final function blogMenu() {
        // Вернем ссылку на содержание блога
        return P::modules()->viewer->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'menu.blog.tpl');
    }

}