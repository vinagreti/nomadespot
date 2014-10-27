<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wishlist extends My_Controller {

    public function index(){

        if($this->session->userdata('logged')){

            $this->rest();

        } else {

            $this->public_list();

        }

    }

    public function public_list() {

        $data = array();

        $conteudo = $this->load->view('wishlist/public', $data, true);

        $css_files = array();

        $js_files = array('js/wishlist');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_html() {

    	$data = array();

        $content = $this->load->view('wishlist/index', $data, true);

        $css_files = array('third-party/typeahead/typeahead-bootstrap3-fix', 'third-party/bootstrap-datepicker/bootstrap-datepicker');

        $js_files = array('js/bostag', 'js/wishlist', 'third-party/bostable/src/bostable', 'third-party/typeahead/typeahead', 'third-party/bootstrap-datepicker/bootstrap-datepicker', 'third-party/bootstrap-datepicker/bootstrap-datepicker.pt-BR');

        $this->template->load($content, $js_files, $css_files, null);

    }

    public function getObjects_json($filter){

        $page = isset($filter['page']) ? $filter['page'] : 1;

        $limit = isset($filter['limit']) ? $filter['limit'] : 30;

    	$this->load->model("wishlist_model");

    	$wishes = $this->wishlist_model->getObjects(false, $page, $limit, true);

        header('X-Total-Count: ' . $wishes['total']);

    	header('Content-Type: application/json');

    	echo json_encode($wishes['digest']);

    }

    public function createForm(){

    	$this->load->view("wishlist/createForm");

    }

    public function readTemplate(){

        $this->load->view("wishlist/readTemplate");

    }

    public function updateForm(){

        $this->load->view("wishlist/updateForm");

    }

    public function deleteForm(){

        $this->load->view("wishlist/deleteForm");

    }

    public function postObject( $data ){

        $this->load->model("wishlist_model");

        $createObject = $this->wishlist_model->postObject( $data );

        if( $createObject['success'] ){

            redirect(base_url().'wishlist/?id='.$createObject['id'].'&format=json');

        }

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $createObject['error'] );

        }

    }

    public function patchObject( $id, $data ){

        $this->load->model("wishlist_model");

        $patchObject = $this->wishlist_model->patchObject( $id, $data );

        if( $patchObject['success'] ){

            redirect(base_url().'wishlist?id='.$id.'&format=json', 'location', 303);

        }

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $patchObject['error'] );

        }

    }

    public function getObject_json( $id ){

        $this->load->model("wishlist_model");

        $carregarObjecto = $this->wishlist_model->getObject($id);

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

        $this->load->model("wishlist_model");

        $deletarObjeto = $this->wishlist_model->deleteObject($id);

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