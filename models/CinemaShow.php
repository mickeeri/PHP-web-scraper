<?php

namespace model;

class CinemaShow
{
    private $movie;
    private $day;
    private $time;
    private $seatsAvailable = false;

    public function __construct($movieTitle, $day, $time, $seatsAvailable)
    {
        if ($seatsAvailable === 1) {
            $this->seatsAvailable = true;
        }

        $this->movie = $movieTitle;
        $this->day = $day;
        $this->time = $time;
    }




    public function getSeatsAvailable()
    {
        return $this->seatsAvailable;
    }

    /**
     * @return mixed
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }
}