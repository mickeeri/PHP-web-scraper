<?php

namespace scraper;

class CalendarScraper extends \scraper\Scraper {

    private $calendarURL;
    private $dom;

    private static $calendarPath = "calendar/";
    private static $fridayString = "Friday";
    private static $saturdayString = "Saturday";
    private static $sundayString = "Sunday";

    public function __construct($url)
    {
        $this->calendarURL = $url.self::$calendarPath;
        $this->dom = new \DOMDocument();
    }

    /**
     * @return array with days that are available for everybody.
     * @throws \Exception
     */
    public function scrapeCalendars()
    {
        // 1. Get data on calendar page with curl.
        $calendarsPage = $this->curlGetRequest($this->calendarURL);
        // 2. Get href to all the calendars on that page.
        $calendarOwnerPages = $this->getCalendarPaths($calendarsPage);
        // 3. Scrape the info from the calendars.
        $persons = $this->getCalendarInfo($calendarOwnerPages);
        // 4. Find and return array with free days.
        return $this->findAvailableDay($persons);
    }

    /**
     * Scrapes the href:s to the different calendars.
     * @param string $data HTML-page
     * @return array $calendarPages paths to different calendars.
     * @throws \Exception
     */
    private function getCalendarPaths($data)
    {

        $calendarPages = array();

        if ($this->dom->loadHTML($data)) {

            $xpath = new \DOMXPath($this->dom);
            $persons = $xpath->query("//a");

            /* @var $person \DOMElement */
            foreach($persons as $person) {
                $calendarPages[] = $person->getAttribute("href");
            }
        } else {
            throw new \Exception("Fel vid läsning av HTML");
        }

        return $calendarPages;
    }

    /**
     * Loops through all the calendar owners calendars, reads and add their calendar entries.
     * @param array $calendarPaths url paths to all the calendars.
     * @return array $calendarOwners list of all the owners and calendar entries.
     */
    private function getCalendarInfo($calendarPaths)
    {

        $enteredURL = $this->calendarURL;
        $calendarOwners = array();

        foreach ($calendarPaths as $path) {
            $url = $enteredURL.$path;
            // Reads calendar for every person.
            $page = $this->curlGetRequest($url);
            $calendarOwners[] = $this->getCalendar($page);
        }

        return $calendarOwners;
    }

    /**
     * Scrapes calendar table and creates Person objects with name and calendar entries.
     * @param string $page calendar HTML-page
     * @return \model\Person $person calendar owner with entries and availability.
     * @throws \Exception
     */
    private function getCalendar($page)
    {

        if ($this->dom->loadHTML($page)) {

            $xpath = new \DOMXPath($this->dom);

            // Get all td tags.
            $availabilityStatuses = $xpath->query("//td");
            $days = $xpath->query("//th");

            // Get calendar owner name from header.
            $header = $xpath->query("//h2");
            $name = $header->item(0)->nodeValue;

            // Crate new object person with that name.
            $person = new \model\Person($name);

            // Loops through all the days. Since it is a table, day and availability has same index.
            for ($i = 0; $i < $days->length; $i++) {

                $day = $days->item($i)->nodeValue;
                $isAvailable = false;

                // Checks if string in td-tag is ok. If it is set boolean to true.
                if (strtolower($availabilityStatuses->item($i)->nodeValue) === "ok") {
                    $isAvailable = true;
                }

                //Creates and adds entry to person object.
                $entry = new \model\CalendarEntry($day, $isAvailable);
                $person->addCalendarEntry($entry);
            }

            return $person;

        } else {
            throw new \Exception("Fel vid läsning av HTML");
        }
    }

    /**
     * Function checks the persons availability on the days in calendar.
     * @param array $persons containing Person objects.
     * @return array
     */
    private function findAvailableDay($persons)
    {

        // As default availability is set to true, but changes to false if one of
        // the members isn't available on a particular day.
        $isFridayAvailable = true;
        $isSaturdayAvailable = true;
        $isSundayAvailable = true;

        /* @var $person \model\Person */
        foreach ($persons as $person) {

            /* @var $entry \model\CalendarEntry */
            foreach ($person->getCalendarEntries() as $entry) {
                if ($entry->getDay() === self::$fridayString && $entry->getIsAvailable() === false) {
                    $isFridayAvailable = false;
                }
                if ($entry->getDay() === self::$saturdayString && $entry->getIsAvailable() === false) {
                    $isSaturdayAvailable = false;
                }
                if ($entry->getDay() === self::$sundayString && $entry->getIsAvailable() === false) {
                    $isSundayAvailable = false;
                }
            }
        }

        // Creates day object and adds to array of available days.
        $availableDays = array();

        if ($isFridayAvailable) {
            $availableDays[] = new \model\Day(self::$fridayString);
        }

        if ($isSaturdayAvailable) {
            $availableDays[] = new \model\Day(self::$saturdayString);
        }

        if ($isSundayAvailable) {
            $availableDays[] = new \model\Day(self::$sundayString);
        }

        return $availableDays;
    }
}