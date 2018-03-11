<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Libros extends REST_Controller {

    public function __construct($config = 'rest') {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
          die();
        }
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
		    $this->load->model("Modelo");
    }

		public function libros_get(){
		  $arr = $this->Modelo->query("SELECT * FROM libro");
			$this->response($arr);
		}
}
