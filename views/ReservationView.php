<?php

namespace view;


class ReservationView
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @return string confirmation of table reservation.
     */
    public function response()
    {
        return
            '<div class="alert alert-success" role="alert">
                <span class="sr-only">Success:</span>
                '.$this->response.'
            </div>

            <a href="?result"><< Tillbaka</a>

            ';
    }
}