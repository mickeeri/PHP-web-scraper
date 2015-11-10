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

}