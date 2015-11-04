<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 15:56
 */

class CalendarReader {

    private static $fridayString = "Friday";
    private static $saturdayString = "Saturday";
    private static $sundayString = "Sunday";

    public function readCalendars($calendarsPage) {
        $calendarOwnerPages = $this->getCalendarPaths($calendarsPage);
        $persons = $this->getCalendarInfo($calendarOwnerPages);


        return $this->findAvailableDay($persons);
    }

    /**
     * Reads the links to the different calendars.
     * @param string $data HTML-page
     * @return array $calendarPages paths to different calendars.
     */
    private function getCalendarPaths($data) {
        $dom = new DOMDocument();
        $calendarPages = array();

        if ($dom->loadHTML($data)) {
            $xpath = new DOMXPath($dom);
            $persons = $xpath->query("//a");


            /* @var $person DOMElement */
            foreach($persons as $person) {
                $calendarPages[] = $person->getAttribute("href");
            }
        }

        return $calendarPages;
    }

    /**
     * Loops through all the calendar owners calendars and reads their calendar entries.
     * @param array $calendarPaths url paths to all the calendars.
     * @return array $calendarOwners list of all the owners and calendar entries.
     */
    private function getCalendarInfo($calendarPaths) {

        $enteredURL = "http://localhost:8080/calendar/";
        $calendarOwners = array();

        foreach ($calendarPaths as $path) {
            $url = $enteredURL.$path;
            $page = curlGetRequest($url);
            $calendarOwners[] = $this->getCalendar($page);
        }

        return $calendarOwners;
    }

    /**
     * Scrapes calendar table and creates Person objects with name and calendar entries.
     * @param string $page calendar HTML-page
     * @return Person $person calendar owner with entries and availability.
     */
    private function getCalendar($page) {

        $dom = new DOMDocument();
        //$entries = array();

        if ($dom->loadHTML($page)) {
            $xpath = new DOMXPath($dom);
            // Get all td tags.
            $availabilityStatuses = $xpath->query("//td");
            $days = $xpath->query("//th");

            // Get calendar owner name from header.
            $header = $xpath->query("//h2");
            $name = $header->item(0)->nodeValue;
            // Crate new object person with that name.
            $person = new Person($name);

            // Loops through all the days. Day and availability has same index.
            for ($i = 0; $i < $days->length; $i++) {

                $day = $days->item($i)->nodeValue;
                $isAvailable = false;

                // checks if string in td-tag is ok.
                if (strtolower($availabilityStatuses->item($i)->nodeValue) === "ok") {
                    $isAvailable = true;
                }

                // Creates and adds entry to person object.
                $entry = new CalendarEntry($day, $isAvailable);
                $person->addCalendarEntry($entry);
            }

            return $person;

        } else {
            die("Error while reading HTML");
        }
    }


    /**
     * Function checks the persons availability on the days in calendar.
     * @param array $persons containing Person objects.
     */
    private function findAvailableDay($persons) {
        // As default availability is set to true, but changes to false if one of
        // the members isn't available on a particular day.
        $isFridayAvailable = true;
        $isSaturdayAvailable = true;
        $isSundayAvailable = true;

        /* @var $person Person */
        foreach ($persons as $person) {
            /* @var $entry CalendarEntry */
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

        $availableDays = array();

        if ($isFridayAvailable) {
            $availableDays[] = self::$fridayString;
        }

        if ($isSaturdayAvailable) {
            $availableDays[] = self::$saturdayString;
        }

        if ($isSundayAvailable) {
            $availableDays[] = self::$sundayString;
        }

        return $availableDays;
    }
}