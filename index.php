<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 11:40
 */

require_once("calendarReader.php");
require_once("calendarEntry.php");
require_once("person.php");

// curl_cookie_handling("http://localhost:63342/1dv449_laboration1/index.php");

$data = curlGetRequest("http://localhost:8080/calendar/");
$calendarOwnerPages = getCalendarPages($data);
getCalendarInfo($calendarOwnerPages);

function curlGetRequest($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function getCalendarPages($data) {
    $dom = new DOMDocument();
    $calendarPages = array();

    if ($dom->loadHTML($data)) {
        $xpath = new DOMXPath($dom);
        $persons = $xpath->query("//a");

        foreach($persons as $person) {
            $calendarPages[] = $person->getAttribute("href");
        }
    }

    return $calendarPages;
}

function getCalendarInfo($calendarPaths) {

    $enteredURL = "http://localhost:8080/calendar/";
    $calendarReader = new CalendarReader();
    $persons = array();

    foreach ($calendarPaths as $path) {
        $url = $enteredURL.$path;
        $page = curlGetRequest($url);
        $persons[] = $calendarReader->getCalendar($page);
    }

    var_dump($persons);
}


/*function curl_cookie_handling($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $post_arr = array(+
        "url" => "http://localhost:8080/"
    );

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);

    $data = curl_exec($ch);
    curl_close($ch);

    var_dump($data);
}*/