<?php

namespace model;

class Movie
{
    private $title;
    private $selectValue;

    /**
     * Movie constructor.
     * @param $title string Movie title
     * @param $selectValue string value of HTML select field option.
     */
    public function __construct($title, $selectValue)
    {
        $this->title = $title;
        $this->selectValue = $selectValue;
    }

    public function getSelectValue() {
        return $this->selectValue;
    }

    public function getTitle() {
        return $this->title;
    }

}