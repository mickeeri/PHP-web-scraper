<?php
/**
 * Created by PhpStorm.
 * User: Micke
 * Date: 2015-11-10
 * Time: 21:08
 */

namespace model;


class DinnerTime
{

    private $day;
    private $startTime;
    private $endTime;


    public function __construct($day, $startTime, $endTime)
    {
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return string containing information to post to make reservation of table.
     */
    public function getReservationQuery()
    {
        $day = "";

        if ($this->day === "Fredag") {
            $day = "fre";
        }
        elseif ($this->day === "Lördag") {
            $day = "lor";
        }
        elseif($this->day === "Söndag") {
            $day = "son";
        }

        return $day.$this->startTime.$this->endTime;
    }

}