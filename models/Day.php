<?php

namespace model;


class Day
{
    private $day;
    private $availableShows;

    private static $fridayString = "Friday";
    private static $saturdayString = "Saturday";
    private static $sundayString = "Sunday";

    private static $fridaySWE = "Fredag";
    private static $saturdaySWE = "Lördag";
    private static $sundaySWE = "Söndag";

    /**
     * AvailableDay constructor.
     * @param $day string day of the week
     */
    public function __construct($day)
    {
        $this->day = $day;
        $this->availableShows = array();
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }


    /**
     * Returns days translated to swedish.
     * @return null|string
     */
    public function getDayInSwedish()
    {

        if ($this->day === self::$fridayString) {
            return self::$fridaySWE;
        }

        if($this->day === self::$saturdayString) {
            return self::$saturdaySWE;
        }

        if($this->day === self::$sundayString) {
            return self::$sundaySWE;
        }

        return null;
    }

    public function getShows() {
        return $this->availableShows;
    }

    /**
     * Add shows that takes place on the particular day.
     * @param $show \model\CinemaShow
     */
    public function addShow($show)
    {
        $this->availableShows[] = $show;
    }
}