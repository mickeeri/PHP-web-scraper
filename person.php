<?php
/**
 * Created by PhpStorm.
 * User: Micke
 * Date: 2015-11-04
 * Time: 16:39
 */

class Person {

    private $name;
    private $calendarEntries = array();

    public function __construct($name) {
        $this->name = $name;
    }

    public function addCalendarEntry(CalendarEntry $entry) {
        $this->calendarEntries[] = $entry;
    }
}