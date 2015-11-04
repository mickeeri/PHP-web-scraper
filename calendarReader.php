<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 15:56
 */

class CalendarReader {

    public function getCalendar($data) {

        $dom = new DOMDocument();
        //$entries = array();

        if ($dom->loadHTML($data)) {
            $xpath = new DOMXPath($dom);
            // Get all td tags.
            $availabilities = $xpath->query("//td");
            $days = $xpath->query("//th");

            // Get calendar owner name form header.
            $header = $xpath->query("//h2");
            $name = $header->item(0)->nodeValue;
            // Crate new object person with that name.
            $person = new Person($name);

            for ($i = 0; $i < $days->length; $i++) {

                $day = $days->item($i)->nodeValue;
                $isAvailable = false;

                // checks if string is in td-tag is ok.
                if (strtolower($availabilities->item($i)->nodeValue) === "ok") {
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
}