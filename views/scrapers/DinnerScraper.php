<?php

namespace view;


class DinnerScraper
{
    private $dinnerURL;
    private $show;


    private static $dinnerPath = "dinner/";


    /**
     * DinnerScraper constructor.
     * @param $url
     * @param $show \model\CinemaShow
     */
    public function __construct($url, $show)
    {
        $this->dinnerURL = $url.self::$dinnerPath;
        $this->show = $show;
    }


}