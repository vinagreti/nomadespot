<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends My_Controller {

	public function index(){ $this->rest(); }

    public function getObjects_html() {

    	$data = array();

    	$this->load->model("currency_model");

    	$currency = $this->currency_model->getLatest();

    	$currency->rates = (array) json_decode($currency->rates);

    	$currency->rates['rates'] = (array) $currency->rates['rates'];

        $content = $this->load->view('currency/index', $currency, true);

        $this->template->load($content, null, null, null);

    }

    public function getObjects_json(){

    	$this->load->model("currency_model");

    	$currency = $this->currency_model->getObjects();

    	header('Content-Type: application/json');

    	echo json_encode($currency);

    }

}