<?php

namespace model;


class MovieDay
{
    private $day;
    private $selectValue;

    public function __construct($day, $selectValue)
    {
        $this->day = $day;
        $this->selectValue = $selectValue;
    }

    public function getDay() {
        return $this->day;
    }

    public function getSelectValue() {
        return $this->selectValue;
    }

}