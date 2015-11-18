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

    /**
     * Add available shows to day.
     * @throws \Exception
     */
    public function addAvailableShowsToDay()
    {

        // Get the HTML select option value of entered day.
        $daySelectValue = $this->getDaySelectValue();

        // Get all movies on that days page.
        $movies = $this->getMovies();

        /* @var $movie \model\Movie */
        foreach ($movies as $movie) {

            // Get request with this query returns json that contains info about movie and availability.
            $request = "check?day=".$daySelectValue."&movie=".$movie->getSelectValue();
            $response = $this->curlGetRequest($this->cinemaURL.$request);
            $decodedResponse = json_decode($response);

            foreach ($decodedResponse as $show) {
                $status = $show->{"status"};
                $time = $show->{"time"};
                // Creates object with title, day, time and availability.
                $show = new \model\CinemaShow($movie->getTitle(), $this->availableDay->getDayInSwedish(), $time, $status);

                // Add show to day if available for everybody.
                if ($show->getSeatsAvailable()) {
                    $this->availableDay->addShow($show);
                }
            }
        }
    }

    /**
     * @return array with movies on particular day.
     * @throws \Exception
     */
    private function getMovies()
    {

        $movies = array();

        if ($this->dom->loadHTML($this->cinemaPage)) {
            $xpath = new \DOMXPath($this->dom);
            $movieSelects = $xpath->query("//select[@name='movie']//option[@value!='']");

            /* @var $movieSelect \DOMElement */
            foreach ($movieSelects as $movieSelect) {
                $movie = new \model\Movie($movieSelect->nodeValue, $movieSelect->getAttribute("value"));
                $movies[] = $movie;
            }

        } else {
            throw new \Exception("Fel vid läsning av HTML på biosidan.");
        }

        return $movies;
    }

    /**
     * Gets the value of HTML select option element.
     * @return string Select option value. For example Friday has value "01".
     * @throws \Exception
     */
    private function getDaySelectValue()
    {

        if ($this->dom->loadHTML($this->cinemaPage)) {

            $xpath = new \DOMXPath($this->dom);
            $daySelects = $xpath->query("//select[@name='day']//option[@value!='']");

            /* @var $daySelect \DOMElement */
            foreach ($daySelects as $daySelect) {

                if ($daySelect->nodeValue === $this->availableDay->getDayInSwedish()) {
                    return $daySelect->getAttribute("value");
                }
            }
        } else {
            throw new \Exception("Fel vid läsning av HTML på biosidan.");
        }
    }
}