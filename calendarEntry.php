<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 16:02
 */

class CalendarEntry {

    private $day;
    private $isAvailable;

    public function __construct($day, $isAvailable) {
        $this->day = $day;
        $this->isAvailable = $isAvailable;
    }

    public  function  getDay() {
        return $this->day;
    }

    public function  getIsAvailable() {
        return $this->isAvailable;
    }
}