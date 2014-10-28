<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends My_Controller {

    public function index() {

        $this->load->model("gallery_model");

    	$data = array('total_images' => $gpa = $this->gallery_model->getObjects(null, null, null, null, true));

        $conteudo = $this->load->view('gallery/index', $data, true);

        $this->template->load($conteudo, null, null, null); // carrega a pagina inicial

    }

    public function images_upload(){

        $total_images = !empty($_FILES['images']) ? count($_FILES['images']['name']) : 0;

        if( $total_images > 0 ){

            $this->load->model("gallery_model");

            $upload = $this->gallery_model->postObject();

            if($upload['success']){

                $response = $upload['msg'];
                $status_header = 200;

            } else {

                $response = $upload['msg'];
                $status_header = 400;

            }

        } else {

            $response = 'Nenhuma imagem recebida.';
            $status_header = 400;

        }

        $this->output
            ->set_status_header($status_header)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }
}