<?php

namespace view;


class ReservationView
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function response() {
        return
            '<div class="alert alert-success" role="alert">
                <span class="sr-only">Success:</span>
                '.$this->response.'
            </div>

            <a href="?">Tillbaka till start</a>

            ';
    }
}