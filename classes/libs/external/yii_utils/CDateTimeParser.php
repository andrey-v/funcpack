<?php
/**
 * CDateTimeParser class file
 *
 * @author    Wei Zhuo <weizhuo[at]gamil[dot]com>
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @author    Tomasz Suchanek <tomasz[dot]suchanek[at]gmail[dot]com>
 * @link      http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

/**
 * CDateTimeParser converts a date/time string to a UNIX timestamp according to the specified pattern.
 *
 * The following pattern characters are recognized:
 * <pre>
 * Pattern |      Description
 * ----------------------------------------------------
 * d       | Day of month 1 to 31, no padding
 * dd      | Day of month 01 to 31, zero leading
 * M       | Month digit 1 to 12, no padding
 * MM      | Month digit 01 to 12, zero leading
 * MMM     | Abbreviation representation of month (available since 1.1.11; locale aware since 1.1.13)
 * MMMM    | Full name representation (available since 1.1.13; locale aware)
 * yy      | 2 year digit, e.g., 96, 05
 * yyyy    | 4 year digit, e.g., 2005
 * h       | Hour in 0 to 23, no padding
 * hh      | Hour in 00 to 23, zero leading
 * H       | Hour in 0 to 23, no padding
 * HH      | Hour in 00 to 23, zero leading
 * m       | Minutes in 0 to 59, no padding
 * mm      | Minutes in 00 to 59, zero leading
 * s       | Seconds in 0 to 59, no padding
 * ss      | Seconds in 00 to 59, zero leading
 * a       | AM or PM, case-insensitive (since version 1.1.5)
 * ?       | matches any character (wildcard) (since version 1.1.11)
 * ----------------------------------------------------
 * </pre>
 * All other characters must appear in the date string at the corresponding positions.
 *
 * For example, to parse a date string '21/10/2008', use the following:
 * <pre>
 * $timestamp=CDateTimeParser::parse('21/10/2008','dd/MM/yyyy');
 * </pre>
 *
 * Locale specific patterns such as MMM and MMMM uses {@link CLocale} for retrieving needed information.
 *
 * To format a timestamp to a date string, please use {@link CDateFormatter}.
 *
 * @author  Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.utils
 * @since   1.0
 */
class CDateTimeParser {

    private static $charset = 'UTF-8';
    /**
     * @var boolean whether 'mbstring' PHP extension available. This static property introduced for
     * the better overall performance of the class functionality. Checking 'mbstring' availability
     * through static property with predefined status value is much faster than direct calling
     * of function_exists('...').
     * Intended for internal use only.
     * @since 1.1.13
     */
    private static $_mbstringAvailable;

    /**
     * Converts a date string to a timestamp.
     * @param string $value    the date string to be parsed
     * @param string $pattern  the pattern that the date string is following
     * @param array  $defaults the default values for year, month, day, hour, minute and second.
     *                         The default values will be used in case when the pattern doesn't specify the
     *                         corresponding fields. For example, if the pattern is 'MM/dd/yyyy' and this
     *                         parameter is array('minute'=>0, 'second'=>0), then the actual minute and second
     *                         for the parsing result will take value 0, while the actual hour value will be
     *                         the current hour obtained by date('H'). This parameter has been available since version 1.1.5.
     * @return integer timestamp for the date string. False if parsing fails.
     */
    public static function parse($value, $pattern = 'MM/dd/yyyy', $defaults = array()) {
        if (self::$_mbstringAvailable === NULL)
            self::$_mbstringAvailable = extension_loaded('mbstring');

        $tokens = self::tokenize($pattern);
        $i = 0;
        $n = self::$_mbstringAvailable ? mb_strlen($value, self::$charset) : strlen($value);
        foreach ($tokens as $token) {
            switch ($token) {
                case 'yyyy':
                {
                    if (($year = self::parseInteger($value, $i, 4, 4)) === FALSE)
                        return FALSE;
                    $i += 4;
                    break;
                }
                case 'yy':
                {
                    if (($year = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($year);
                    break;
                }
                case 'MMMM':
                {
                    $monthName = '';
                    if (($month = self::parseMonth($value, $i, 'wide', $monthName)) === FALSE)
                        return FALSE;
                    $i += self::$_mbstringAvailable ? mb_strlen($monthName, self::$charset) : strlen($monthName);
                    break;
                }
                case 'MMM':
                {
                    $monthName = '';
                    if (($month = self::parseMonth($value, $i, 'abbreviated', $monthName)) === FALSE)
                        return FALSE;
                    $i += self::$_mbstringAvailable ? mb_strlen($monthName, self::$charset) : strlen($monthName);
                    break;
                }
                case 'MM':
                {
                    if (($month = self::parseInteger($value, $i, 2, 2)) === FALSE)
                        return FALSE;
                    $i += 2;
                    break;
                }
                case 'M':
                {
                    if (($month = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($month);
                    break;
                }
                case 'dd':
                {
                    if (($day = self::parseInteger($value, $i, 2, 2)) === FALSE)
                        return FALSE;
                    $i += 2;
                    break;
                }
                case 'd':
                {
                    if (($day = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($day);
                    break;
                }
                case 'h':
                case 'H':
                {
                    if (($hour = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($hour);
                    break;
                }
                case 'hh':
                case 'HH':
                {
                    if (($hour = self::parseInteger($value, $i, 2, 2)) === FALSE)
                        return FALSE;
                    $i += 2;
                    break;
                }
                case 'm':
                {
                    if (($minute = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($minute);
                    break;
                }
                case 'mm':
                {
                    if (($minute = self::parseInteger($value, $i, 2, 2)) === FALSE)
                        return FALSE;
                    $i += 2;
                    break;
                }
                case 's':
                {
                    if (($second = self::parseInteger($value, $i, 1, 2)) === FALSE)
                        return FALSE;
                    $i += strlen($second);
                    break;
                }
                case 'ss':
                {
                    if (($second = self::parseInteger($value, $i, 2, 2)) === FALSE)
                        return FALSE;
                    $i += 2;
                    break;
                }
                case 'a':
                {
                    if (($ampm = self::parseAmPm($value, $i)) === FALSE)
                        return FALSE;
                    if (isset($hour)) {
                        if ($hour == 12 && $ampm === 'am')
                            $hour = 0;
                        elseif ($hour < 12 && $ampm === 'pm')
                            $hour += 12;
                    }
                    $i += 2;
                    break;
                }
                default:
                    {
                    $tn = self::$_mbstringAvailable ? mb_strlen($token, self::$charset) : strlen($token);
                    if ($i >= $n || ($token{0} != '?' && (self::$_mbstringAvailable ? mb_substr($value, $i, $tn, self::$charset) : substr($value, $i, $tn)) !== $token))
                        return FALSE;
                    $i += $tn;
                    break;
                    }
            }
        }
        if ($i < $n)
            return FALSE;

        if (!isset($year))
            $year = isset($defaults['year']) ? $defaults['year'] : date('Y');
        if (!isset($month))
            $month = isset($defaults['month']) ? $defaults['month'] : date('n');
        if (!isset($day))
            $day = isset($defaults['day']) ? $defaults['day'] : date('j');

        if (strlen($year) === 2) {
            if ($year >= 70)
                $year += 1900;
            else
                $year += 2000;
        }
        $year = (int)$year;
        $month = (int)$month;
        $day = (int)$day;

        if (
            !isset($hour) && !isset($minute) && !isset($second)
            && !isset($defaults['hour']) && !isset($defaults['minute']) && !isset($defaults['second'])
        )
            $hour = $minute = $second = 0;
        else {
            if (!isset($hour))
                $hour = isset($defaults['hour']) ? $defaults['hour'] : date('H');
            if (!isset($minute))
                $minute = isset($defaults['minute']) ? $defaults['minute'] : date('i');
            if (!isset($second))
                $second = isset($defaults['second']) ? $defaults['second'] : date('s');
            $hour = (int)$hour;
            $minute = (int)$minute;
            $second = (int)$second;
        }

        if (CTimestamp::isValidDate($year, $month, $day) && CTimestamp::isValidTime($hour, $minute, $second))
            return CTimestamp::getTimestamp($hour, $minute, $second, $month, $day, $year);
        else
            return FALSE;
    }

    /*
     * @param string $pattern the pattern that the date string is following
     */
    private static function tokenize($pattern) {
        if (!($n = self::$_mbstringAvailable ? mb_strlen($pattern, self::$charset) : strlen($pattern)))
            return array();
        $tokens = array();
        $c0 = self::$_mbstringAvailable ? mb_substr($pattern, 0, 1, self::$charset) : substr($pattern, 0, 1);

        for ($start = 0, $i = 1; $i < $n; ++$i) {
            $c = self::$_mbstringAvailable ? mb_substr($pattern, $i, 1, self::$charset) : substr($pattern, $i, 1);
            if ($c !== $c0) {
                $tokens[] = self::$_mbstringAvailable ? mb_substr($pattern, $start, $i - $start, self::$charset) : substr($pattern, $start, $i - $start);
                $c0 = $c;
                $start = $i;
            }
        }
        $tokens[] = self::$_mbstringAvailable ? mb_substr($pattern, $start, $n - $start, self::$charset) : substr($pattern, $start, $n - $start);
        return $tokens;
    }

    /**
     * @param string  $value     the date string to be parsed
     * @param integer $offset    starting offset
     * @param integer $minLength minimum length
     * @param integer $maxLength maximum length
     * @return string parsed integer value
     */
    protected static function parseInteger($value, $offset, $minLength, $maxLength) {
        for ($len = $maxLength; $len >= $minLength; --$len) {
            $v = self::$_mbstringAvailable ? mb_substr($value, $offset, $len, self::$charset) : substr($value, $offset, $len);
            if (ctype_digit($v) && (self::$_mbstringAvailable ? mb_strlen($v, self::$charset) : strlen($v)) >= $minLength)
                return $v;
        }
        return FALSE;
    }

    /**
     * @param string  $value  the date string to be parsed
     * @param integer $offset starting offset
     * @return string parsed day period value
     */
    protected static function parseAmPm($value, $offset) {
        $v = strtolower(self::$_mbstringAvailable ? mb_substr($value, $offset, 2, self::$charset) : substr($value, $offset, 2));
        return $v === 'am' || $v === 'pm' ? $v : FALSE;
    }

    /**
     * @param string  $value     the date string to be parsed.
     * @param integer $offset    starting offset.
     * @param string  $width     month name width. It can be 'wide', 'abbreviated' or 'narrow'.
     * @param string  $monthName extracted month name. Passed by reference.
     * @return string parsed month name.
     * @since 1.1.13
     */
    protected static function parseMonth($value, $offset, $width, &$monthName) {
        $valueLength = self::$_mbstringAvailable ? mb_strlen($value, self::$charset) : strlen($value);
        for ($len = 1; $offset + $len <= $valueLength; $len++) {
            $monthName = self::$_mbstringAvailable ? mb_substr($value, $offset, $len, self::$charset) : substr($value, $offset, $len);
            if (!preg_match('/^[\p{L}\p{M}]+$/u', $monthName)) // unicode aware replacement for ctype_alpha($monthName)
            {
                $monthName = self::$_mbstringAvailable ? mb_substr($monthName, 0, -1, self::$charset) : substr($monthName, 0, -1);
                break;
            }
        }
        $monthName = self::$_mbstringAvailable ? mb_strtolower($monthName, self::$charset) : strtolower($monthName);

        $monthNames = MonthNames::get($width);
        foreach ($monthNames as $k => $v)
            $monthNames[$k] = rtrim(self::$_mbstringAvailable ? mb_strtolower($v, self::$charset) : strtolower($v), '.');

        $monthNamesStandAlone = MonthNames::get($width);
        foreach ($monthNamesStandAlone as $k => $v)
            $monthNamesStandAlone[$k] = rtrim(self::$_mbstringAvailable ? mb_strtolower($v, self::$charset) : strtolower($v), '.');

        if (($v = array_search($monthName, $monthNames)) === FALSE && ($v = array_search($monthName, $monthNamesStandAlone)) === FALSE)
            return FALSE;
        return $v;
    }
}

class MonthNames {
    static public function get($width) {

        $language = P::modules()->lang->GetLang();


        if ($language == 'russian') {
            $data = array(
                'wide'        =>
                    array(
                        1  => 'января',
                        2  => 'февраля',
                        3  => 'марта',
                        4  => 'апреля',
                        5  => 'мая',
                        6  => 'июня',
                        7  => 'июля',
                        8  => 'августа',
                        9  => 'сентября',
                        10 => 'октября',
                        11 => 'ноября',
                        12 => 'декабря',
                    ),
                'abbreviated' =>
                    array(
                        1  => 'янв.',
                        2  => 'февр.',
                        3  => 'марта',
                        4  => 'апр.',
                        5  => 'мая',
                        6  => 'июня',
                        7  => 'июля',
                        8  => 'авг.',
                        9  => 'сент.',
                        10 => 'окт.',
                        11 => 'нояб.',
                        12 => 'дек.',
                    ),
                'narrow'      =>
                    array(
                        1  => 'Я',
                        2  => 'Ф',
                        3  => 'М',
                        4  => 'А',
                        5  => 'М',
                        6  => 'И',
                        7  => 'И',
                        8  => 'А',
                        9  => 'С',
                        10 => 'О',
                        11 => 'Н',
                        12 => 'Д',
                    ),
            );

            return $data[$width];
        } else {
            $data = array(
                'wide'        =>
                    array(
                        1  => 'January',
                        2  => 'February',
                        3  => 'March',
                        4  => 'April',
                        5  => 'May',
                        6  => 'June',
                        7  => 'July',
                        8  => 'August',
                        9  => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ),
                'abbreviated' =>
                    array(
                        1  => 'Jan',
                        2  => 'Feb',
                        3  => 'Mar',
                        4  => 'Apr',
                        5  => 'May',
                        6  => 'Jun',
                        7  => 'Jul',
                        8  => 'Aug',
                        9  => 'Sep',
                        10 => 'Oct',
                        11 => 'Nov',
                        12 => 'Dec',
                    ),
                'narrow'      =>
                    array(
                        1  => 'J',
                        2  => 'F',
                        3  => 'M',
                        4  => 'A',
                        5  => 'M',
                        6  => 'J',
                        7  => 'J',
                        8  => 'A',
                        9  => 'S',
                        10 => 'O',
                        11 => 'N',
                        12 => 'D',
                    ));

            return $data[$width];
        }
    }
}
