<?php

namespace view;


class ErrorView
{
    private $errorMessage;

    public function __construct($em)
    {
        $this->errorMessage = $em;
    }

    public function response() {
        return

            '<div class="alert alert-danger" role="alert">
                <span class="sr-only">Error:</span>
                '.$this->errorMessage.'
            </div>

            <a href="?">Tillbaka till formulär</a>

            ';
    }
}