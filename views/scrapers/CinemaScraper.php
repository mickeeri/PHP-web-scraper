<?php
/**
 * Created by PhpStorm.
 * User: Micke
 * Date: 2015-11-10
 * Time: 09:52
 */

namespace view;

//Request URL:http://localhost:8080/cinema/check?day=01&movie=03

// "[{"status":1,"time":"16:00","movie":"03"},{"status":0,"time":"18:00","movie":"03"},{"status":0,"time":"21:00","movie":"03"}]"
// status: 1 = available seats. 2 = full.


class CinemaScraper extends \view\Scraper
{
    private $cinemaURL;
    private $availableDays = array();
    private static $cinemaPath = "cinema/";

    private static $friday = "01";
    private static $saturday = "02";
    private static $sunday = "03";

    private static $soderKokar = "01";
    private static $fabianBom = "02";
    private static $pensionatParadiset = "03";


    public function __construct($url, $days)
    {
        $this->cinemaURL = $url.self::$cinemaPath;
        $this->availableDays = $days;
    }

    public function scrapeCinemaPage() {

        $day = "01";
        $movie = "03";
        $requestURL = 'check?day='.$day.'&movie='.$movie;

        $movies = $this->getMovies();

        //var_dump($this->cinemaURL.$requestURL);
        var_dump($this->curlGetRequest($this->cinemaURL.$requestURL));
    }

    private function getMovies() {

    }
}