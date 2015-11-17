<?php

namespace scraper;


class DinnerScraper extends \scraper\Scraper
{
    private $dinnerURL;
    private $dom;
    private $dinnerPage;
    private static $dinnerPath = "dinner/";
    private $day;

    /**
     * DinnerScraper constructor.
     * @param $url
     * @param $day \model\Day
     */
    public function __construct($url, $day)
    {
        $this->dinnerURL = $url.self::$dinnerPath;
        $this->day = $day;
        $this->dinnerPage = $this->curlGetRequest($this->dinnerURL);
        $this->dom = new \DOMDocument();
    }

    /**
     * Checks for available tables on certain day.
     * @throws \Exception
     * @internal param \model\Day $day
     */
    public function scrapeDinnerPage()
    {
        $tablesAvailableOnDay = array();

        if ($this->dom->loadHTML($this->dinnerPage)) {

            $xpath = new \DOMXPath($this->dom);

            // Tables that are not fully booked have type radio.
            $tableInputs = $xpath->query("//input[@type='radio']");

            /* @var $input \DOMElement */
            foreach ($tableInputs as $input) {

                // Get value of input-element.
                $inputValue = $input->getAttribute('value');

                // Remove all numbers to get day.
                $inputDay = preg_replace('/[0-9]+/', '', $inputValue);
                // Remove all letters to get time only.
                $timeString = preg_replace('/\D/', '', $inputValue);
                // First two numbers is start hour.
                $start = intval(substr($timeString, 0, -2));
                // Last two numbers is end hour.
                $end = intval(substr($timeString, 2));

                // If the day in radio-buttons value equals the provided day.
                if ($inputDay === $this->day->getDayShortSWE()) {
                    // Create and add table to day.
                    $table = new \model\DinnerTable($inputDay, $start, $end);
                    $tablesAvailableOnDay[] = $table;
                }
            }

            // Calls method to check and add table to show.
            foreach ($tablesAvailableOnDay as $availableTable) {
                $this->checkAndAddTableToShow($availableTable);
            }

        } else {
            throw new \Exception("Kunde inte läsa HTML på restaurangsidan.");
        }
    }

    /**
     * Check if available table is after movie show. In that case adds them to show object.
     * @param $table \model\DinnerTable
     */
    private function checkAndAddTableToShow($table)
    {
        /** @var \model\CinemaShow $show */
        foreach ($this->day->getShows() as $show) {
            // Movie is at the most two hours.
            $movieEndHour = intval($show->getTime()) + 2;

            // If dinnertime starts after movie.
            if ($table->getStartTime() >= $movieEndHour) {
                // Add table to show.
                $show->addAvailableTable($table);
            }
        }
    }


}