<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends My_Controller {

    public function index() {

    	$data = array();

        $this->load->model("articles_model");

        $data['article'] = $this->articles_model->getObject(1)["object"]->content;

        $conteudo = $this->load->view('project/index', $data, true);

        $this->template->load($conteudo, null, null, null); // carrega a pagina inicial

    }

}