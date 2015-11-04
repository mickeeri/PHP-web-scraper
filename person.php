<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 16:39
 */

class Person {

    private $name;
    private $calendarEntries = array();

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function addCalendarEntry(CalendarEntry $entry) {
        $this->calendarEntries[] = $entry;
    }

    public  function getCalendarEntries() {
        return $this->calendarEntries;
    }
}