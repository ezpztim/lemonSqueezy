<?php

	class Controller {

		function model($model) {
			require_once $_SERVER['DOCUMENT_ROOT'] . "/psi/app/models/" . $model . ".php";
			return new $model();
		}

		function view($view, $data = []) {
			require_once $_SERVER['DOCUMENT_ROOT'] . "/psi/app/views/" . $view . ".php";
		}
	}