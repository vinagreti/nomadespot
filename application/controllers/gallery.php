<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends My_Controller {

    public function index() {

        $this->load->model("gallery_model");

    	$data = array('total_images' => $gpa = $this->gallery_model->getObjects(null, null, null, null, true));

        $conteudo = $this->load->view('gallery/index', $data, true);

        $this->template->load($conteudo, null, null, null); // carrega a pagina inicial

    }

    public function images() {

        $this->load->model("gallery_model");

        $gpa = $this->gallery_model->getObjects();

        $data = array('gpa' => $gpa['digest'], 'bucket' => 'guaraniporai');

        $conteudo = $this->load->view('gallery/images', $data, true);

        $css_files = array('css/bootstrap3-button-file');

        $this->template->load($conteudo, null, $css_files, null); // carrega a pagina inicial

    }

    public function images_upload(){

        $total_images = !empty($_FILES['images']) ? count($_FILES['images']['name']) : 0;

        if( $total_images > 0 ){

            $this->load->model("gallery_model");

            $uploaded = $this->gallery_model->postObject();

            if($uploaded){

                $response = $uploaded; // responde

            } else {

                $response = $uploaded['msg'];

            }


        } else
            $response = 'Nenhuma imagem recebida.';

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }
}