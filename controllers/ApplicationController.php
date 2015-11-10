<?php

namespace controller;

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
            $availableDays = $calendarScraper->scrapeCalendars();

            // 2. Scrape available movies on those days.
            $cinemaScraper = new \view\CinemaScraper($url, $availableDays);
            $cinemaScraper->scrapeCinemaPage();


            // cinemaScarper returns list with days and time. Object(title, day, time)?

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