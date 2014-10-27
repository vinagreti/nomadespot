<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends My_Controller {

    public function index() {

    	$data = array();

        $conteudo = $this->load->view('dashboard/index', $data, true);

        $javascript_files = array('js/dashboard');

        $this->template->load($conteudo, $javascript_files, null, null); // carrega a pagina inicial

    }

}