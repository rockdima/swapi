<?php

class Swapi {

	/**
	 * 
	 * get persons by page
	 * @param string $page page url
	 * @return array 
	 */
	function getPersons($page) {
		//get current page
		$page = $this->setPage($page);
		//get list and turn into array
		return json_decode(file_get_contents($page), true);
	}

	/**
	 * 
	 * sets current page
	 * @param string $page page url
	 * @return string
	 */
	private function setPage($page) {
		//if page isset return it if not set the default page
		return $page ?? 'https://swapi.co/api/people';
	}
}