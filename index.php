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
require_once("layout.php");

// curl_cookie_handling("http://localhost:63342/1dv449_laboration1/index.php");
$layout = new Layout();
$calendarsPage = curlGetRequest("http://localhost:8080/calendar/");
$cr = new CalendarReader();
$availableDays = $cr->readCalendars($calendarsPage);
$layout->render($availableDays);

function curlGetRequest($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}


// TODO: Form for entering url.
// TODO: Days as enums.


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