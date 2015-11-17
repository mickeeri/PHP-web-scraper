<?php
/**
 * Created by PhpStorm.
 * User: Micke
 * Date: 2015-11-10
 * Time: 21:08
 */

namespace model;


class DinnerTable
{

    private $day;
    private $startTime;
    private $endTime;


    /**
     * DinnerTable constructor.
     * @param $day string Day that dinner takes place.
     * @param $startTime int Time that dinner starts.
     * @param $endTime int Time when dinner ends.
     */
    public function __construct($day, $startTime, $endTime)
    {
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return string query-string containing day and time for reservation, info used to post dinner reservation.
     * For example "lor1820"
     */
    public function getReservationQuery()
    {
//        $day = "";
//
//        if ($this->day === "Fredag") {
//            $day = "fre";
//        }
//        elseif ($this->day === "Lördag") {
//            $day = "lor";
//        }
//        elseif($this->day === "Söndag") {
//            $day = "son";
//        }

        return $this->day.$this->startTime.$this->endTime;
    }

}