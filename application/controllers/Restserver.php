<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Restserver extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
		    $this->load->model("Modelo");
    }

		public function users_get(){
		  $arr = $this->Modelo->query("SELECT * FROM usuario", [$this->input->get("id")]);
			$this->response($arr);
		}

		public function users_delete(){
			$nombre = $this->input->delete("nombre");
			$edad = $this->input->delete("edad");
			$this->response([
				"nombre" => $nombre,
				"edad" => $edad
			]);
		  // echo($this->input->post("id"));
		}
}
