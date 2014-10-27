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

        var_dump($_FILES);

        $total_images = count($_FILES['images']['name']);

        if( $total_images > 0 ){

            $this->load->model("gallery_model");

            $uploaded = $this->gallery_model->postObject();

            if($uploaded){

                echo json_encode( $uploaded ); // responde

            } else {

                echo json_encode($uploaded['msg']);

            }


        } else
            echo json_encode('A página espera por um POST.');

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

    }
}