<?php

class Router {
	private $pages = array();


	function addRoute($url, $path) {
		$this->pages[$url] = $path;
	}

	function route($url) {
		$path = $this->pages[$url];
		$file_dir = "pages/".$path;

		if ($path == "") {
			require 'pages/error.php';
			die();
		}

		if (file_exists($file_dir)) {
			require $file_dir;
		} else {
			require 'pages/error.php';
			die();
		}
	}
}

?>