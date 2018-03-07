<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Libros extends REST_Controller {

    public function __construct() {
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
