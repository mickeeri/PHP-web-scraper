<?php

namespace view;

class FormView
{
    private static $urlInputID = "url";
    private static $submitPostID = "submit";
    private $errorMessage = "";
    private $defaultURL;

    /**
     * FormView constructor.
     */
    public function __construct()
    {
        if ($_SERVER['HTTP_HOST'] === "localhost:63342") {
            $this->defaultURL = "http://localhost:8080/";
        } else {
            $this->defaultURL = "http://46.101.232.43/";
        }
    }

    public function response()
    {
        return $this->generateURLForm();
    }

    private function generateURLForm()
    {
        $form =
        ''.$this->getMessage().'
        <form class="form-inline" method="post">
            <div class="form-group">
                <label for="urlinput">Ange URL: </label>
                <input id="urlinput" type="text" value="'.$this->defaultURL.'" name="'.self::$urlInputID.'">
            </div>
            <input id="sendurl" class="btn btn-primary" type="submit" value="Skicka"
            data-loading-text="Skickar..." name="'.self::$submitPostID.'">
        </form>';

        return $form;
    }

    /**
     * @return bool true if user has pressed form submit button.
     */
    public function userWantsToSubmitURL()
    {
        return isset($_POST[self::$submitPostID]);
    }

    /**
     * @return null|$url string posted url
     */
    public function getSubmittedURL()
    {
        $url = $_POST[self::$urlInputID];

        if ($url === "") {
            $this->errorMessage = "Fältet får inte vara tomt";
            return null;
        } else {
            return $url;
        }
    }

    /**
     * @return string div element with error message.
     */
    private function getMessage()
    {
        if ($this->errorMessage !== "") {

            return
                '<div class="alert alert-danger">
                    <span class="sr-only">Error:</span>
                    ' . $this->errorMessage . '
                </div>';
        }

        return "";
    }
}