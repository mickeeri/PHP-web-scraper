<?php

namespace view;

class ResultView
{
    private $days;

    /**
     * ResultView constructor.
     * @param $availableDays array with days.
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
            $this->renderDays().'
            <a href="?"><< Tillbaka</a>
            ';
    }

    private function renderDays()
    {
        $ret = '';

        /* @var $day \model\Day */
        foreach ($this->days as $day) {
            $ret .=
            '<h3>'.$day->getDayInSwedish().'</h3>
            <h4>Föreställningar</h4>
            <ul class="list-group">
                '.$this->renderShows($day).'
            </ul>
            ';
        }

        return $ret;
    }

    /**
     * @param $day \model\Day
     * @return string
     */
    private function renderShows($day)
    {
        $ret = '';
        $i = 1;

        /* @var $show \model\CinemaShow */
        foreach ($day->getShows() as $show) {

            // Renders info about show and available tables with help of bootstrap collapse.
            $ret .=
                '<li class="list-group-item">
                    <strong>'.$show->getMovie().'</strong> visas kl <strong>'.$show->getTime().'</strong>
                    <a data-toggle="collapse" href="#availableTables'.$i.'"
                    aria-expanded="false" aria-controls="availableTables'.$i.'">
                        Visa lediga bord >>
                    </a>
                    <div class="collapse" id="availableTables'.$i.'">
                        <div class="well">
                            <strong>Lediga bord på Zekes efter föreställningen:</strong><br>
                            '.$this->renderAvailableTables($show).'
                        </div>
                    </div>
                </li>';

            ++$i;
        }
        return $ret;
    }


    /**
     * @param $show \model\CinemaShow
     * @return string HTML
     */
    private function renderAvailableTables($show)
    {
        $ret = '';
        $tables = $show->getAvailableTables();

        if (empty($tables)) {
            $ret .= 'Inga lediga bord';
        } else {
            /* @var $table\model\DinnerTable */
            foreach ($tables as $table) {
                $ret .= $table->getStartTime().':00 - '.$table->getEndTime().':00.
                    <a href="?book='.$table->getReservationQuery().'">Boka</a><br>';
            }
        }

        return $ret;
    }
}