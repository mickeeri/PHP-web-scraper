<?php

namespace model;

class Person {

    private $name;
    private $calendarEntries = array();

    /**
     * Person constructor.
     * @param $name string
     */
    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * Add calendar entry to person.
     * @param CalendarEntry $entry
     */
    public function addCalendarEntry(\model\CalendarEntry $entry) {
        $this->calendarEntries[] = $entry;
    }

    /**
     * @return array
     */
    public  function getCalendarEntries() {
        return $this->calendarEntries;
    }
}