<?php

class Validate_DateTimeAll extends Zend_Validate_Abstract {

    const INVALID_INPUT_FORMAT = 'datetimeallInvalidInputFormat';
    const INVALID_DATE = 'datetimeInvalidDate';
    const INVALID_TIME = 'datetimeInvalidTime';

    protected $_messageTemplates = array(
        self::INVALID_INPUT_FORMAT => E073V,
        self::INVALID_DATE => "存在しない日付です。",
        self::INVALID_TIME => "存在しない時刻です。"
    );

    public function __construct($datetimeToCompare = null) {
        $this->_datetimeToCompareInUts = $datetimeToCompare ? strtotime($datetimeToCompare) : time();
    }

    public function isValid($value) {
        if(!preg_match('/^([0-9]{4})-([0-9]{2}|[0-9]{1})-([0-9]{2}|[0-9]{1}) ([0-9]{2}|[0-9]{1}):([0-9]{2}|[0-9]{1}):([0-9]{2}|[0-9]{1})$/', $value) ){
            $this->_error(self::INVALID_INPUT_FORMAT);
            return false;
        }
        list($year, $month, $day, $hour, $minute, $second) = sscanf($value, '%d-%d-%d %d:%d:%d');
        if (!checkdate($month, $day, $year)) {
            $this->_error(self::INVALID_DATE);
            return false;
        }
        if (!($hour >= 0 && $hour <= 23) ||!($minute >= 0 && $minute <= 59) ||!($second >= 0 && $second <= 59)) {
            $this->_error(self::INVALID_TIME);
            return false;
        }
        return true;
    }
}

?>