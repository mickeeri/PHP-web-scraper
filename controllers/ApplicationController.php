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

            // 1. Scrape calendar for available days.
            $url = $this->appView->getURLFromCookie();
            $cs = new \view\CalendarScraper($url);
            $availableDays= $cs->scrapeCalendars();

            // 2. Scrape available movies.



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