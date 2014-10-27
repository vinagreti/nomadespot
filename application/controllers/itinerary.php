<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itinerary extends My_Controller {

    public function index() {

    	$data = array();

    	$css = array('css/maps-responsive');

        $conteudo = $this->load->view('itinerary/index', $data, true);

        $this->template->load($conteudo, null, $css, null); // carrega a pagina inicial

    }

}