<?php

namespace scraper;


class DinnerScraper extends \scraper\Scraper
{
    private $dinnerURL;
    private $show;
    private $dom;
    private $dinnerPage;
    private static $dinnerPath = "dinner/";
    private $day;
    private $movieStartTime;
    private $availableDinnerTimes;


    /**
     * DinnerScraper constructor.
     * @param $url
     * @param $show \model\CinemaShow
     */
    public function __construct($url, $show)
    {
        $this->dinnerURL = $url.self::$dinnerPath;
        $this->show = $show;
        $this->day = $this->show->getDay();
        $this->dinnerPage = $this->curlGetRequest($this->dinnerURL);
        $this->dom = new \DOMDocument();
        $this->availableDinnerTimes = array();
        $this->movieStartTime = intval($this->show->getTime());
    }

    /**
     * Add free tables that starts after the provided movie.
     */
    public function addAvailableTablesToShow()
    {

        if ($this->dom->loadHTML($this->dinnerPage)) {

            $xpath = new \DOMXPath($this->dom);

            // Tables that are not fully booked have type radio.
            $tables = $xpath->query("//input[@type='radio']");

            /* @var $table \DOMElement */
            foreach ($tables as $table) {

                $inputValue = $table->getAttribute('value');


                // Remove all numbers to get day.
                $day = preg_replace('/[0-9]+/', '', $inputValue);

                // Remove all letters to get time only.
                $timeString = preg_replace('/\D/', '', $inputValue);
                // First two numbers is start hour.
                $start = intval(substr($timeString, 0, -2));
                // Last two numbers is end hour.
                $end = intval(substr($timeString, 2));

                d($this->day);
                d($day);
                d($timeString);
                d($start);
                ddd($end);



            }




            // Get span element for provided day.
            $spans = $xpath->query("//span[.='".$this->day."']");







            $firstDiv = $spans->item(0)->parentNode->parentNode->parentNode;



            /* @var $firstDiv \DOMElement */
            $secondDivClassName = $firstDiv->nextSibling->nextSibling->nextSibling->nextSibling->getAttribute("class");
            $reservationElement = $xpath->query("//div[@class='".$secondDivClassName."']//p");


            $dinnerTimes = array();

            /* @var $element \DOMElement */
            foreach($reservationElement as $element) {
                // If first child of element has
                if ($element->firstChild->nodeName === "input") {

                    $timeString = preg_replace('/\D/', '', $element->nodeValue);
                    $start = intval(substr($timeString, 0, -2));
                    $end = intval(substr($timeString, 2));
                    $reservation = new \model\DinnerTime($this->day, $start, $end);
                    $dinnerTimes[] = $reservation;

                }
            }

            // Movies length maximum 2 hours.
            $movieEndTime = $this->movieStartTime + 2;

            /* @var $dinnerTime \model\DinnerTime */
            foreach ($dinnerTimes as $dinnerTime) {

                // If dinner starts after movie.
                if ($dinnerTime->getStartTime() >= $movieEndTime) {
                    //$this->availableDinnerTimes[] = $dinnerTime;
                    $this->show->addAvailableTable($dinnerTime);
                }
            }

        } else {
            throw new \Exception("Kunde inte läsa HTML på restaurangsidan.");
        }
    }


}