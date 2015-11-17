<?php

namespace model;

class CinemaShow
{
    private $movie;
    private $day;
    private $time;
    private $seatsAvailable = false;
    private $availableTables;

    /**
     * CinemaShow constructor.
     * @param $movieTitle
     * @param $day
     * @param $time
     * @param $seatsAvailable
     */
    public function __construct($movieTitle, $day, $time, $seatsAvailable)
    {
        if ($seatsAvailable === 1) {
            $this->seatsAvailable = true;
        }

        $this->movie = $movieTitle;
        $this->day = $day;
        $this->time = $time;
        $this->availableTables = array();
    }


    public function getSeatsAvailable()
    {
        return $this->seatsAvailable;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getAvailableTables()
    {
        return $this->availableTables;
    }


    /**
     * Add dinner times that are after the cinema show.
     * @param $dinnerTime \model\DinnerTable
     */
    public function addAvailableTable($dinnerTime)
    {
        $this->availableTables[] = $dinnerTime;
    }

}