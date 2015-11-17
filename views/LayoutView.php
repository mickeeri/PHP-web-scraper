<?php

namespace view;

class LayoutView {

    /**
     * Renders HTML page.
     * @param $view mixed view provided from controller.
     */
    public function render($view) {
        echo '
        <!DOCTYPE html>
		    <html lang="sv">
		      <head>
		        <title>Laboration 1</title>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <link href="css/style.css" rel="stylesheet">
		        <link href="css/bootstrap.min.css" rel="stylesheet">
		  	</head>
	      	<body>
				<div class="container">
					<h1>Laboration 1</h1>
					<div class="content">
                            '.$view->response().'
		            </div>
		        </div>
		        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		        <script src="js/bootstrap.min.js"></script>
		        <script src="js/script.js"></script>
	       	</body>
	    </html>
	    ';
    }
}