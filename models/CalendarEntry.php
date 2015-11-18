<?php

namespace model;

class CalendarEntry
{

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