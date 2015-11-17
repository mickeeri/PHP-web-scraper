<?php

namespace scraper;

// URL looks like this.
//Request URL:http://localhost:8080/cinema/check?day=01&movie=03

// Example of JSON string.
// "[{"status":1,"time":"16:00","movie":"03"},{"status":0,"time":"18:00","movie":"03"},{"status":0,"time":"21:00","movie":"03"}]"
// status: 1 = available seats. 0 = full.


class CinemaScraper extends \scraper\Scraper
{
    private $cinemaURL;
    private $cinemaPage;
    private $dom;
    private $availableDay;
    private static $cinemaPath = "cinema/";

    /**
     * CinemaScraper constructor.
     * @param $url
     * @param $day \model\Day
     */
    public function __construct($url, $day)
    {
        $this->cinemaURL = $url.self::$cinemaPath;
        $this->availableDay = $day;
        $this->cinemaPage = $this->curlGetRequest($this->cinemaURL);
        $this->dom = new \DOMDocument();
    }

    public function addAvailableShowsToDay() {

        // Get the select value of entered day.
        $daySelectValue = $this->getDaySelectValue();

        // Get all movies on that days page.
        $movies = $this->getMovies();

        /* @var $day \model\MovieDay */
        /* @var $movie \model\Movie */
        foreach ($movies as $movie) {

            $request = "check?day=".$daySelectValue."&movie=".$movie->getSelectValue();
            $response = $this->curlGetRequest($this->cinemaURL.$request);
            $decodedResponse = json_decode($response);

            foreach ($decodedResponse as $show) {
                $status = $show->{"status"};
                $time = $show->{"time"};
                //$movieNumber = $show->{"movie"};
                $show = new \model\CinemaShow($movie->getTitle(), $this->availableDay->getDayInSwedish(), $time, $status);

                // Add show to day if available for everybody.
                if ($show->getSeatsAvailable()) {
                    $this->availableDay->addShow($show);
                }
            }
        }
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

    private function getDaySelectValue() {
        if ($this->dom->loadHTML($this->cinemaPage)) {
            $xpath = new \DOMXPath($this->dom);
            $daySelects = $xpath->query("//select[@name='day']//option[@value!='']");

            /* @var $daySelect \DOMElement */
            foreach ($daySelects as $daySelect) {
                if ($daySelect->nodeValue === $this->availableDay->getDayInSwedish()) {
                    return $daySelect->getAttribute("value");
                }
            }
        }

        return false;
    }

//    private function getDays() {
//
//        $days = array();
//
//        if ($this->dom->loadHTML($this->cinemaPage)) {
//            $xpath = new \DOMXPath($this->dom);
//            $daySelects = $xpath->query("//select[@name='day']//option[@value!='']");
//
//            /* @var $daySelect \DOMElement */
//            foreach ($daySelects as $daySelect) {
//                // Check if day is available with $availableDays, result of scrape of calendars.
//
//                foreach ($this->getSwedishNameOfDays() as $availableDay) {
//
//                    if ($daySelect->nodeValue === $availableDay) {
//
//                        // Create new object.
//                        $day = new \model\MovieDay($daySelect->nodeValue, $daySelect->getAttribute("value"));
//                        // Add to array of days.
//                        $days[] = $day;
//                    }
//                }
//            }
//        }
//
//        return $days;
//    }
}