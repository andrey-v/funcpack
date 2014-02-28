<?php
/**
 * Интерфейс валидаторов
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 *
 * @version     ProblemCode RC 1 от 11.10.13 23:34
 */
interface IValidator {

    /**
     * Метод валидации значения
     * @return boolean
     */
    public function validate();

}
