<?php

namespace view;

class MasterView {
	// no222bd - Check to decide wich usecase to run ==============================================================
	public function wantToRegister(){
		return array_key_exists('register', $_GET);
	}

	/**
	 * @return string
	 * retunerar grunden i vår HTML
	 * som ska vara överst på sidan.
	 */
	public function basicHeader(){
		
		// no222bd - Moved and rewritten from view.php =============================================================

		/*return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'> 
        <html  xmlns='http://www.w3.org/1999/xhtml'> 
          <head> 
             <title>Laboration 4</title> 
             <meta http-equiv='content-type' content='text/html; charset='utf-8'/>
          </head> 
          <body>";*/

		return '<!doctype html>

			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
				<title>Laboration 4</title>
			</head>
				<body>';
	}
	
	/**
	 * @return string
	 * retunerar grunden i vår HTML
	 * som ska vara nederst på sidan.
	 * 
	 * !!!NOTERA!!!
	 * @var hour date + 2 är en åtgärd som är nödvändig på webbhotelets server.
	 * Klockan fungerar korrekt utom timmar som visade två timmar för tidigt.
	 * Och dagen som inte kan ta åäö.
	 * Skulle webbhotel bytas eller testas localt kan denna åtgärd kanske tas bort.
	 */
	public function basicFooter(){
			
		// no222bd - Moved and rewritten from view.php =============================================================
		
		/*$hour = date("H") + 2;
		$showDay = "<p> ".strftime('%A');
		$showCorrectDay = utf8_encode($showDay);
		return $showCorrectDay . strftime('den %d %B år %Y. Klockan är: ['. $hour .':%M:%S] ')."</p></body> </html>";*/

		return '<p>' . ucfirst(utf8_encode(strftime('%A'))) . strftime(', den %#d ') . ucfirst(strftime('%B'))
			   . strftime(' år %Y. Klockan är [%H:%M:%S].') . '</p>';
	}
}