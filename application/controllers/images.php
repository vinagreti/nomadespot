<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends My_Controller {

	public function index(){ $this->rest(); }

    public function getObjects_html() {

        $this->load->model("images_model");

        $gpa = $this->images_model->getObjects();

        $data = array('gpa' => $gpa['digest'], 'bucket' => 'guaraniporai');

        $conteudo = $this->load->view('images/index', $data, true);

        $css_files = array('css/bootstrap3-button-file');

        $this->template->load($conteudo, null, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_json( $params ){

    	$this->load->model("images_model");

    	$images = $this->images_model->getObjects( $params );

    	header('Content-Type: application/json');

    	echo json_encode($images['digest']);

    }

    public function postObject( $data ){

        $total_images = !empty($_FILES['images']) ? count($_FILES['images']['name']) : 0;

        if( $total_images > 0 ){

            $this->load->model("images_model");

            $upload = $this->images_model->postObject();

            if($upload['success']){

                $response = $upload;
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

    public function patchObject( $id, $data ){

        $this->load->model("images_model");

        $updateObject = $this->images_model->patchObject( $id, $data );

        if( $updateObject['success'] )
            redirect(base_url().'images/?id='.$id.'&format=json', 'location', 303);

        else{

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($updateObject['error']));

        }

    }

    public function getObject_json( $id ){

        $this->load->model("images_model");

        $carregarObjecto = $this->images_model->getObject($id);

        if( $carregarObjecto["success"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarObjecto["object"]; // insere o objeto na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarObjecto["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarObjecto["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function deleteObject( $id ){

        $this->load->model("images_model");

        $deletarObjeto = $this->images_model->deleteObject($id);

        if( $deletarObjeto["success"] ){ // se a remoção for bem sucedida

            $res = $deletarObjeto["msg"]; // mensagem de success

        } else { // se a remoção não for bem sucedida

            $res = $deletarObjeto["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $deletarObjeto["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

}