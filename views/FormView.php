<?php

namespace view;

class FormView
{
    private static $urlInputID = "url";
    private static $submitPostID = "submit";
    private $errorMessage = "";
    private static $defaultURL = "http://localhost:8080/";

    /**
     * FormView constructor.
     */
    public function __construct()
    {
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
                <label for="'.self::$urlInputID.'">Enter URL: </label>
                <input type="text" value="'.self::$defaultURL.'" name="'.self::$urlInputID.'">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="'.self::$submitPostID.'">
        </form>';

        return $form;
    }

//    private function getInputField()
//    {
//
//    }

    /**
     * @return bool true if user has pressed form submit button.
     */
    public function userWantsToSubmitURL() {
        return isset($_POST[self::$submitPostID]);
    }

    public function getSubmittedURL() {
        $url = $_POST[self::$urlInputID];
        if ($url === "") {
            $this->errorMessage = "You have to enter URL";
            return null;
        } else {
            return $url;
        }
    }

    private function getMessage()
    {
        if ($this->errorMessage !== "") {

            return
                '<div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    ' . $this->errorMessage . '
                </div>';
        }
    }
}