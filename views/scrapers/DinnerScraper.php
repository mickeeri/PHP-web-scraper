<?php

namespace view;


class DinnerScraper extends \view\Scraper
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

    public function addAvailableTablesToShow()
    {

        if ($this->dom->loadHTML($this->dinnerPage)) {
            $xpath = new \DOMXPath($this->dom);
            //$test = $xpath->query("text()=".$this->day."");
            $spans = $xpath->query("//span[.='".$this->day."']");
            //var_dump($test->item(0)->nodeValue);
            //$tests = $xpath->query("//div[@class='WordSection3']");

            $firstDiv = $spans->item(0)->parentNode->parentNode->parentNode;
            /* @var $firstDiv \DOMElement */
            $secondDivClassName = $firstDiv->nextSibling->nextSibling->nextSibling->nextSibling->getAttribute("class");

            $reservationElement = $xpath->query("//div[@class='".$secondDivClassName."']//p");
            // nodeValue = string(15) "14-16 Fullbokat"
            // string(12) "18-20 Ledigt"
            //var_dump($reservationElement);

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

            $movieEndTime = $this->movieStartTime + 2;

            /* @var $dinnerTime \model\DinnerTime */
            foreach ($dinnerTimes as $dinnerTime) {
                // If dinner starts after movie.
                if ($dinnerTime->getStartTime() >= $movieEndTime) {
                    //$this->availableDinnerTimes[] = $dinnerTime;
                    $this->show->addAvailableTable($dinnerTime);
                }
//                // If movie starts after dinner.
//                if ($this->movieStartTime >= $dinnerTime->getEndTime()) {
//
//                    //$this->availableDinnerTimes[] = $dinnerTime;
//                    $this->show->addAvailableTable($dinnerTime);
//                }
                // If movie begins after dinner.
            }

            ///ddd($this->availableDinnerTimes);




        } else {
            // TODO: Kasta undantag.
        }
    }


}