<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Countries extends My_Controller {

	public function index(){ $this->rest(); }

    public function getObjects_json( $params ){

    	$this->load->model("countries_model");

    	$countrie = $this->countries_model->getObjects( $params );

    	header('Content-Type: application/json');

    	echo json_encode($countrie['digest']);

    }

}