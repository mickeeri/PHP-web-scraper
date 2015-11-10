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
// status: 1 = available seats. 0 = full.


class CinemaScraper extends \view\Scraper
{
    private $cinemaURL;
    private $cinemaPage;
    private $dom;
    private $availableDays = array();
    private static $cinemaPath = "cinema/";

    public function __construct($url, $days)
    {
        $this->cinemaURL = $url.self::$cinemaPath;
        $this->availableDays = $days;
        $this->cinemaPage = $this->curlGetRequest($this->cinemaURL);
        $this->dom = new \DOMDocument();
    }

    public function scrapeCinemaPage() {

        // 1. Get days in select field.
        $days = $this->getDays();
        // 1. Get all movies on page.
        $movies = $this->getMovies();

        // 3. Scrape available shows.
        /* @var $day \model\MovieDay */
        foreach ($days as $day) {
            /* @var $movie \model\Movie */
            foreach ($movies as $movie) {
                $request = "check?day=".$day->getSelectValue()."&movie=".$movie->getSelectValue();

                $response = $this->curlGetRequest($this->cinemaURL.$request);
                $decodedResponse = json_decode($response);

//                var_dump($decodedResponse);
//                die();
                foreach ($decodedResponse as $show) {
                    $status = $show->{"status"};
                    $time = $show->{"time"};
                    $movieNumber = $show->{"movie"};
                    $show = new \model\CinemaShow($movie->getTitle(), $day->getDay(), $time, $status);
                    var_dump($show);
                    die();
                }


            }



        }


        //Request URL:http://localhost:8080/cinema/check?day=01&movie=03
        //var_dump($this->cinemaURL.$requestURL);
        // var_dump($this->curlGetRequest($this->cinemaURL.$requestURL));
    }

    private function getMovies() {
        $movies = array();

        if ($this->dom->loadHTML($this->cinemaPage)) {
            $xpath = new \DOMXPath($this->dom);
            $movieSelects = $xpath->query("//select[@name='movie']//option[@value!='']");

            /* @var $movieSelect \DOMElement */
            foreach ($movieSelects as $movieSelect) {
                $movie = new \model\Movie($movieSelect->nodeValue, $movieSelect->getAttribute("value"));
                $movies[] = $movie;
            }
        }

        return $movies;

    }

    private function getDays() {
        //$cinemaPage = $this->curlGetRequest($this->cinemaURL);
        $days = array();
        //$dom = new \DOMDocument();

        if ($this->dom->loadHTML($this->cinemaPage)) {
            $xpath = new \DOMXPath($this->dom);
            $daySelects = $xpath->query("//select[@name='day']//option[@value!='']");

            /* @var $daySelect \DOMElement */
            foreach ($daySelects as $daySelect) {
                // Check if day is available with $availableDays, result of scrape of calendars.

                foreach ($this->getSwedishNameOfDays() as $availableDay) {

                    if ($daySelect->nodeValue === $availableDay) {

                        // Create new object.
                        $day = new \model\MovieDay($daySelect->nodeValue, $daySelect->getAttribute("value"));
                        // Add to array of days.
                        $days[] = $day;
                    }
                }
            }
        }

        return $days;
    }

    private function getSwedishNameOfDays() {

        $availableDaysInSwedish = array();
        // TODO: String dep
        foreach ($this->availableDays as $availableDay) {
            if ($availableDay === "Friday") {
                $availableDaysInSwedish[] = "Fredag";
            }

            if($availableDay === "Saturday") {
                $availableDaysInSwedish[] = "Lördag";
            }

            if($availableDay === "Sunday") {
                $availableDaysInSwedish[] = "Söndag";
            }
        }

        return $availableDaysInSwedish;
    }
}