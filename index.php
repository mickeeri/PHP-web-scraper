<?php

// Models
require_once("models/CalendarEntry.php");
require_once("models/Person.php");
require_once("models/MovieDay.php");
require_once("models/Movie.php");
require_once("models/CinemaShow.php");
require_once("models/Day.php");
require_once("models/DinnerTime.php");

// Views
require_once("views/LayoutView.php");
require_once("views/ApplicationView.php");
require_once("views/ResultView.php");
require_once("views/FormView.php");

// Scrapers
require_once("views/scrapers/Scraper.php");
require_once("views/scrapers/CalendarScraper.php");
require_once("views/scrapers/CinemaScraper.php");
require_once("views/scrapers/DinnerScraper.php");

// Controllers
require_once("controllers/ApplicationController.php");

require_once("../kint-master/Kint.class.php");

libxml_use_internal_errors(TRUE);

// curl_cookie_handling("http://localhost:63342/1dv449_laboration1/index.php");

// Creating views and controllers.
$av = new \view\ApplicationView();
$lv = new \view\LayoutView();
$ac = new \controller\ApplicationController($av);

$ac->handleInput();
$view = $ac->generateOutput();
$lv->render($ac, $view);

// TODO: Feedback att man klickat på knappen skicka.


//$calendarsPage = curlGetRequest("http://localhost:8080/calendar/");
//$cr = new CalendarReader();
//$availableDays = $cr->readCalendars($calendarsPage);

/* Enligt exemplet kan man inte se Söderkåkar som börjar kl: 21 och äta middag mellan 18:00 - 20:00,
men det går att se Söderkåkar kl: 18-20 och äta middag kl 20:00-22:00 */





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