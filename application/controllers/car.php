<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Car extends My_Controller {

    public function index() {

    	$data = array();

        $conteudo = $this->load->view('car/index', $data, true);

        $this->template->load($conteudo, null, null, null); // carrega a pagina inicial

    }

}