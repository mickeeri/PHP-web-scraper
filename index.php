<?php

// Models
require_once("models/CalendarEntry.php");
require_once("models/Person.php");
require_once("models/Movie.php");
require_once("models/CinemaShow.php");
require_once("models/Day.php");
require_once("models/DinnerTable.php");

// Views
require_once("views/LayoutView.php");
require_once("views/ApplicationView.php");
require_once("views/ResultView.php");
require_once("views/FormView.php");
require_once("views/ReservationView.php");
require_once("views/ErrorView.php");

// Scrapers
require_once("scrapers/Scraper.php");
require_once("scrapers/CalendarScraper.php");
require_once("scrapers/CinemaScraper.php");
require_once("scrapers/DinnerScraper.php");
require_once("scrapers/DinnerBooker.php");

// Controllers
require_once("controllers/ApplicationController.php");

// To show better var-dumps
if ($_SERVER['HTTP_HOST'] === "localhost:63342") {
    require_once("../kint-master/Kint.class.php");
}

// Prevent warnings.
libxml_use_internal_errors(TRUE);

// Creating views and controllers.
$av = new \view\ApplicationView();
$lv = new \view\LayoutView();
$ac = new \controller\ApplicationController($av);

// Controller decides which view to render, based on input.
$ac->handleInput();
$view = $ac->generateOutput();
$lv->render($view);