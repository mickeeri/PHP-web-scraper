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

        // User wants to see result of scrape.
        if ($this->appView->onScrapeResultPage()) {

            try {

                $url = $this->appView->getURLFromCookie(true);

                // Scrape calendar for available days.
                $calendarScraper = new \scraper\CalendarScraper($url);
                $availableDays = $calendarScraper->scrapeCalendars();

                /* @var $availableDay \model\Day */
                foreach ($availableDays as $availableDay) {

                    // Scrapes cinema page and adds shows with available seats to day.
                    $cinemaScraper = new \scraper\CinemaScraper($url, $availableDay);
                    $cinemaScraper->addAvailableShowsToDay();

                    // Skrapa efter tillgänliga bord den dagen.
                    // Kolla om det funkar efter en specifik show.

                    // Scrapes restaurant page to find and add available tables.
                    $dinnerScraper = new \scraper\DinnerScraper($url, $availableDay);

                    // Find and add available tables after the show.
                    foreach ($availableDay->getShows() as $show) {
                        $dinnerScraper = new \scraper\DinnerScraper($url, $show);
                        $dinnerScraper->addAvailableTablesToShow();
                    }
                }

                // Set result view.
                $this->view = new \view\ResultView($availableDays);

            } catch (\Exception $e) {
                $this->view = new \view\ErrorView($e->getMessage());
            }
        }
        // User has pressed link to book table.
        elseif ($this->appView->wantsTooBookTable()) {

            try {
                $url = $this->appView->getURLFromCookie(false);
                // Get time and day for reservation from by GET.
                $query = $this->appView->getReservationTime();
                $db = new \scraper\DinnerBooker($url);
                // Get and display response to booking.
                $response = $db->curlPostRequest($query);
                $this->view = new \view\ReservationView($response);
            } catch (\Exception $e) {
                $this->view = new \view\ErrorView($e->getMessage());
            }
        }
        // User is on default page.
        else {
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

    /**
     * @return view\ to render in LayoutView
     */
    public function generateOutput()
    {
        return $this->view;
    }
}