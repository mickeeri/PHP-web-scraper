<?php

namespace view;

class ResultView
{
    private $days;
    private $shows;


    /**
     * ResultView constructor.
     * @param $availableDays array with days.
     * @param $availableShows array with available shows.
     */
    public function __construct($availableDays)
    {
        $this->days = $availableDays;
    }

    public function response()
    {
        return $this->renderResult();
    }

    private function renderResult()
    {
        return
            '<h2>Tillgängliga dagar</h2>
            '.$this->renderDays().'
            <a href="?"><< Tillbaka</a>
            ';
    }

    private function renderDays() {

        $ret = '';

        /* @var $day \model\Day */
        foreach ($this->days as $day) {
            $ret .=
            '<h3>'.$day->getDayInSwedish().'</h3>
            <h4>Föreställningar</h4>
            <ul class="list-group">
                '.$this->renderShowsAndDinner($day).'
            </ul>
            ';
        }

        return $ret;
    }

    /**
     * @param $day \model\Day
     * @return string
     */
    private function renderShowsAndDinner($day)
    {
        $list = '';

        /* @var $show \model\CinemaShow */
        foreach ($day->getShows() as $show) {
            $list .= '<li class="list-group-item active">Kl '.$show->getTime().' visas '.$show->getMovie().'</li>
            '.$this->renderAvailableTables($show).'
            ';

        }

        return $list;
    }

    private function renderAvailableTables($show)
    {
        $ret = '';

        /* @var $show \model\CinemaShow */
        /* @var $table\model\DinnerTime */
        foreach ($show->getAvailableTables() as $table) {
            $ret .= '<li class="list-group-item">Ledigt bord på Zekes mellan '.$table->getStartTime().':00 och '.$table->getEndTime().':00</li>';
        }

        return $ret;
    }

//    private function renderShowsList()
//    {
//        $list = '';
//
//        /* @var $show \model\CinemaShow */
//        foreach ($this->shows as $show) {
//            $list .= '<li class="list-group-item">'.$show->getDay().' kl '.$show->getTime().' visas '.$show->getMovie().'</li>';
//        }
//
//        return $list;
//    }


}