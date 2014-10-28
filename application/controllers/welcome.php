<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends My_Controller {

    public function index() {

    	$data = array();

        $this->load->model("images_model");

        $data['images'] = $this->images_model->getObjects()['digest'];

        $conteudo = $this->load->view('welcome/index', $data, true);

        $css_files = array('css/bootstrap3-flex-videos', 'css/bootstrap3-resposive-carrousel');

        $this->template->load($conteudo, null, $css_files, null); // carrega a pagina inicial

    }

}