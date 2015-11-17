<?php

namespace model;


class MovieDay
{
    private $day;
    private $selectValue;

    /**
     * MovieDay constructor.
     * @param $day string Day of movie show.
     * @param $selectValue string value of HTML select field.
     */
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