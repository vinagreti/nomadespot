<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends My_Controller {

	public function index(){ $this->rest(); }

    public function getObjects_json( $params ){

    	$this->load->model("users_model");

    	$countrie = $this->users_model->getObjects( $params );

    	header('Content-Type: application/json');

    	echo json_encode($countrie['digest']);

    }

}