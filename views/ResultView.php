<?php

namespace view;

class ResultView
{
    private $days;

    /**
     * ScrapeResultView constructor.
     * @param array $availableDays
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
            '<h2>Result</h2>
                <ul class="list-group">
                    '.$this->renderResultList().'
                </ul>
            ';
    }

    private function renderResultList() {

        $list = '';

        /* @var $day string */
        foreach ($this->days as $day) {
            $list .= '<li class="list-group-item">'.$day.' works fine for everybody</li>';
        }

        return $list;
    }


}