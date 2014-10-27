<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inspirations extends My_Controller {

    public function index(){

        if($this->session->userdata('logged')){

            $this->rest();

        } else {

            $this->public_list();

        }

    }

    public function public_list() {

        $data = array();

        $conteudo = $this->load->view('inspirations/public', $data, true);

        $css_files = array();

        $js_files = array('js/inspirations');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_html() {

        $data = array();

        $conteudo = $this->load->view('inspirations/index', $data, true);

        $css_files = array('third-party/typeahead/typeahead-bootstrap3-fix');

        $js_files = array('js/bostag', 'js/inspirations', 'third-party/bostable/src/bostable', 'third-party/typeahead/typeahead');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_json($filter){

        $page = isset($filter['page']) ? $filter['page'] : 1;

        $limit = isset($filter['limit']) ? $filter['limit'] : 30;

        $this->load->model("inspirations_model");

        $wishes = $this->inspirations_model->getObjects(false, $page, $limit, true);

        header('X-Total-Count: ' . $wishes['total']);

        header('Content-Type: application/json');

        echo json_encode($wishes['digest']);

    }

    public function createForm(){

        $this->load->view("inspirations/createForm");

    }

    public function readTemplate(){

        $this->load->view("inspirations/readTemplate");

    }

    public function updateForm(){

        $this->load->view("inspirations/updateForm");

    }

    public function deleteForm(){

        $this->load->view("inspirations/deleteForm");

    }

    public function postObject( $data ){

        $this->load->model("inspirations_model");

        $createObject = $this->inspirations_model->postObject( $data );

        if( $createObject['success'] )
            redirect(base_url().'inspirations/?id='.$createObject['id'].'&format=json');

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $createObject['error'] );

        }

    }

    public function getObject_json( $id ){

        $this->load->model("inspirations_model");

        $carregarObjecto = $this->inspirations_model->getObject($id);

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

        $this->load->model("inspirations_model");

        $deletarObjeto = $this->inspirations_model->deleteObject($id);

        if( $deletarObjeto["success"] ){ // se a remoção for bem sucedida

            $res = $deletarObjeto["msg"]; // mensagem de success

        } else { // se a remoção não for bem sucedida

            $res = $deletarObjeto["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $deletarObjeto["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function patchObject( $id, $data ){

        $this->load->model("inspirations_model");

        $patchObject = $this->inspirations_model->patchObject( $id, $data );

        if( $patchObject['success'] ){

            redirect(base_url().'inspirations?id='.$id.'&format=json', 'location', 303);

        }

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $patchObject['error'] );

        }

    }
}