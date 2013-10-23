<?php
/**
 * Файл валидатора ValidatorEmail
 * ValidatorEmail проверяет строку на правильность написания email
 * <br><br>
 * Для валидатора определены следующие модификаторы:
 * <ul>
 *      <li><b>mx</b>: Проверять ли MX запись адреса, по умолчанию FALSE. Если включить, то нужно быть уверенным, что
 *      функция 'checkdnsrr' присутствует в установке Вашего PHP. Проверка может быть проведена с ошибкой из-за
 *      временных проблем с сетью северами и т.д.</li>
 *      <li><b>empty</b>: Флаг, указывающий, что проверяются только целочисленные значения, по умолчанию FALSE</li>
 *      <li><b>idn</b>: Проверять ли адрес представленные как IDN (internationalized domain names), ели ложь, то IDN
 *      адрес всегда будут невалидными при проверке</li>
 *      <li><b>message</b>: сообщение, которое будет вызвано при ошибке валидации, если не указано, то выведется сообщение по
 *      умолчанию</li>
 *      <li><b>value</b>: проверяемое число.</li>
 *</ul>
 *
 * @author      Андрей Г. Воронов <andreyv@gladcode.ru>
 * @copyright   Copyright © 2013, Андрей Г. Воронов
 *              Является частью плагина funcPack
 * @copyright   Copyright © 2008-2013 Yii Software LLC
 *              Используется программный код фреймворка Yii (http://www.yiiframework.com/),
 *              распространяемый по лицензии http://www.yiiframework.com/license/
 *
 * @version     ProblemCode RC 1 от 19.10.13 00:39
 */
class ValidatorEmail extends Validator implements IValidator {
    /**
     * Регулярное выражение для проверки email
     * @var string
     * @see http://www.regular-expressions.info/email.html
     */
    private $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    /**
     * Проверять ли MX запись адреса, по умолчанию FALSE. Если включить, то нужно быть уверенным, что функция
     * 'checkdnsrr' присутствует в установке Вашего PHP. Проверка может быть проведена с ошибкой из-за временных
     * проблем с сетью северами и т.д.
     * @var bool
     */
    public $bCheckMX = FALSE;
    /**
     * Разрешать ли пустое значение
     * @var boolean
     */
    public $bAllowEmpty = FALSE;
    /**
     * Проверять ли адрес представленные как IDN (internationalized domain names), ели ложь, то IDN адрес всегда
     * будут невалидными при проверке
     * @var boolean
     */
    public $bValidateIDN = FALSE;
    /**
     * Массив модификаторов и соответствий их свойствам объекта
     * @var array
     */
    protected $_aModifier = [
        'mx'    => 'bCheckMX',
        'empty' => 'bAllowEmpty',
        'idn'   => 'bValidateIDN',
    ];

    /**
     * Ошибка в адресе
     */
    const ERROR_CODE_EMAIL = 0;
    /**
     * Ошибка в проверке MX записи
     */
    const ERROR_CODE_MX = 1;

    /**
     * Получим дефолтное сообщение об ошибке
     */
    final public function getMessage() {
        if ($this->sMessage)
            return $this->sMessage;

        switch ($this->iErrorCode) {
            case self::ERROR_CODE_EMAIL:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_email_email');
            case self::ERROR_CODE_MX:
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_email_mx');
            default :
                return $this->sMessage = P::modules()->lang->Get('plugin.funcpack.validator_email_default');
        }
    }

    /**
     * Проверка текущего значения
     * @return bool
     */
    public function validate() {
        if ($this->bAllowEmpty && $this->isEmpty($this->xValue))
            return TRUE;

        if (is_string($this->xValue) && $this->bValidateIDN)
            $this->xValue = $this->encodeIDN($this->xValue);

        // проверим длину адреса для избежания DOS атаки
        $bResult = is_string($this->xValue) && strlen($this->xValue) <= 254 && (preg_match($this->pattern, $this->xValue));
        if (!$bResult) {
            $this->iErrorCode = self::ERROR_CODE_EMAIL;
        }

        if ($bResult && $this->bCheckMX && function_exists('checkdnsrr')) {
            $domain = rtrim(substr($this->xValue, strpos($this->xValue, '@') + 1), '>');
            $bResult = checkdnsrr($domain, 'MX');
            if (!$bResult) {
                $this->iErrorCode = self::ERROR_CODE_MX;
            }
        }

        if (!$bResult) {
            $this->addError();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Преобразует данный IDN в код.
     * @param string $value IDN.
     * @return string выходной код
     */
    private function encodeIDN($value) {
        if (preg_match_all('/^(.*)@(.*)$/', $value, $matches)) {
            if (function_exists('idn_to_ascii'))
                $value = $matches[1][0] . '@' . idn_to_ascii($matches[2][0]);
            else {
                include_once dirname(__FILE__) . '/../libs/external/Net_IDNA2/Net/IDNA2.php';
                $idna = new Net_IDNA2();
                $value = $matches[1][0] . '@' . @$idna->encode($matches[2][0]);
            }
        }
        return $value;
    }
}