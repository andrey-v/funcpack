<?php
/**
 * Файл валидатора ValidatorUrl
 * ValidatorUrl проверяет, что переданное значение является валидным url
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemPony RC 1 от 12.10.13 01:06
 */
class ValidatorUrl extends Validator implements IValidator {
    /**
     * Регулярка проверки значения
     * @var string
     */
    private $pattern = '/^{schemes}:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';
    /**
     * Валидные URI схемы
     * @var array
     * @since 1.1.7
     **/
    public $aValidScheme = ['http', 'https'];
    /**
     * Дефолтная URI схема
     * @var string
     **/
    private $sDefaultScheme;
    /**
     * Разрешать ли пустое значение
     * @var boolean
     */
    public $bAllowEmpty = FALSE;
    /**
     * Проверять ли домены представленные как IDN (internationalized domain names), ели ложь, то IDN домены всегда
     * будут невалидными при проверке
     * @var boolean
     */
    public $bValidateIDN = FALSE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'validSchemes'  => 'aValidScheme',
        'validateIDN'   => 'bValidateIDN',
        'empty'         => 'bAllowEmpty',
    ];

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if (!$this->sMessage)
            $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_default_url', ['xValue' => $this->xValue]);

        return $this->sMessage;
    }

    /**
     * Проверка текущего значения
     * @return bool
     */
    public function validate() {
        if (is_string($this->xValue) && strlen($this->xValue) < 2000) // make sure the length is limited to avoid DOS attacks
        {
            if ($this->sDefaultScheme !== NULL && strpos($this->xValue, '://') === FALSE)
                $this->xValue = $this->sDefaultScheme . '://' . $this->xValue;

            if ($this->bValidateIDN)
                $this->xValue = $this->encodeIDN($this->xValue);

            if (strpos($this->pattern, '{schemes}') !== FALSE)
                $pattern = str_replace('{schemes}', '(' . implode('|', $this->aValidScheme) . ')', $this->pattern);
            else
                $pattern = $this->pattern;

            if (preg_match($pattern, $this->xValue))
                return TRUE;
        }

        P::modules()->message->AddErrorSingle($this->getMessage(), P::modules()->lang->Get('error'));
        return FALSE;
    }

    /**
     * Преобразует данный IDN в код.
     * @param string $value IDN.
     * @return string выходной код
     */
    private function encodeIDN($value) {
        if (preg_match_all('/^(.*):\/\/([^\/]+)(.*)$/', $value, $matches)) {
            if (function_exists('idn_to_ascii'))
                $value = $matches[1][0] . '://' . idn_to_ascii($matches[2][0]) . $matches[3][0];
            else {
                include_once dirname(__FILE__) . '/../libs/external/Net_IDNA2/Net/IDNA2.php';
                $idna = new Net_IDNA2();
                $value = $matches[1][0] . '://' . @$idna->encode($matches[2][0]) . $matches[3][0];
            }
        }
        return $value;
    }

}