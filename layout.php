<?php
/**
 * Created by PhpStorm.
 * User: me222wm
 * Date: 2015-11-04
 * Time: 19:37
 */

class Layout {

    public function render($availableDays) {
        echo '
        <!DOCTYPE html>
		    <html lang="en">
		      <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <link href="css/style.css" rel="stylesheet">
		        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		        <title>Laboration 1</title>
		  	</head>
	      	<body>
				<div class="container">
					<h1>Laboration 1</h1>
					<div class="content">
                        <ul class="list-group">
                            '.$this->renderAvailableDays($availableDays).'
                        </ul>
		            </div>
		        </div>
	       	</body>
	    </html>
	    ';
    }

    private function renderAvailableDays($availableDays) {
        $ret = '';

        foreach ($availableDays as $day) {
            $ret .= '<li class="list-group-item">'.$day.' works good for everybody</li>';
        }

        return $ret;
    }

}