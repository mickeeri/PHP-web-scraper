<?php

namespace controller;

use model\Day;

class ApplicationController
{
    private $appView;
    private $view;


    /**
     * ApplicationController constructor.
     * @param \view\ApplicationView $av
     */
    public function __construct($av)
    {
        $this->appView = $av;
    }

    public function handleInput()
    {
        if ($this->appView->onScrapeResultPage()) {


            $url = $this->appView->getURLFromCookie();

            // 1. Scrape calendar for available days.
            $calendarScraper = new \view\CalendarScraper($url);
            //$testSunday = new \model\Day("Sunday");

            // TODO: Test med annan dag.
            $availableDays = $calendarScraper->scrapeCalendars();
            //$availableDays[] = $testSunday;

            /* @var $availableDay \model\Day */
            foreach ($availableDays as $availableDay) {
                $cinemaScraper = new \view\CinemaScraper($url, $availableDay);
                // Scrapes cinema page and adds shows with available seats to day.
                $cinemaScraper->addAvailableShowsToDay();

                // Find dinner reservations matching cinema shows.
                foreach ($availableDay->getShows() as $show) {
                    $dinnerScraper = new \view\DinnerScraper($url, $show);
                    $dinnerScraper->findAvailableTables();
                }
            }



            $this->view = new \view\ResultView($availableDays);
        } else {
            $this->view = new \view\FormView();

            if ($this->view->userWantsToSubmitURL()) {
                $url = $this->view->getSubmittedURL();
                if (isset($url)) {
                    $this->appView->saveURLInCookie($url);
                    $this->appView->redirectToResultPage();
                }
            }
        }
    }

    public function generateOutput()
    {
        return $this->view;
    }
}