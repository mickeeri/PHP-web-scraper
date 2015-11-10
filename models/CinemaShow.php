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
}