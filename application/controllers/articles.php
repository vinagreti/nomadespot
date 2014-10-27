<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends My_Controller {

    public function index(){ $this->rest(); }

    public function getPublicObjects_html() {

        $data = array();

        $conteudo = $this->load->view('articles/public', $data, true);

        $css_files = array('css/bootstrap3-flex-videos');

        $js_files = array('js/articles');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getPublicObjects_json() {

        $page = isset($filter['page']) ? $filter['page'] : 1;

        $limit = isset($filter['limit']) ? $filter['limit'] : 30;

        $this->load->model("articles_model");

        $wishes = $this->articles_model->getObjects(false, $page, $limit, true);

        header('X-Total-Count: ' . $wishes['total']);

        header('Content-Type: application/json');

        echo json_encode($wishes['digest']);

    }

    public function getPublicObject_json( $id ){

        $this->load->model("articles_model");

        $carregarObjecto = $this->articles_model->getObject($id);

        if( $carregarObjecto["success"] ){ // se a consulta ao banco for bem sucedida

            nl2br($carregarObjecto["object"]->content);

            $res = $carregarObjecto["object"]; // insere o objeto na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarObjecto["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarObjecto["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function getObjects_html() {

        $data = array();

        $conteudo = $this->load->view('articles/index', $data, true);

        $css_files = array('third-party/typeahead/typeahead-bootstrap3-fix', 'third-party/summernote/summernote', 'third-party/summernote/summernote-bs3', 'css/bootstrap3-flex-videos');

        $js_files = array('js/bostag', 'js/articles', 'third-party/bostable/src/bostable', 'third-party/typeahead/typeahead', 'third-party/summernote/summernote.min');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_json($filter){

        $page = isset($filter['page']) ? $filter['page'] : 1;

        $limit = isset($filter['limit']) ? $filter['limit'] : 30;

        $this->load->model("articles_model");

        $wishes = $this->articles_model->getObjects(false, $page, $limit, true);

        header('X-Total-Count: ' . $wishes['total']);

        header('Content-Type: application/json');

        echo json_encode($wishes['digest']);

    }

    public function createForm(){

        $this->load->view("articles/createForm");

    }

    public function readTemplate(){

        $this->load->view("articles/readTemplate");

    }

    public function updateForm(){

        $this->load->view("articles/updateForm");

    }

    public function deleteForm(){

        $this->load->view("articles/deleteForm");

    }

    public function postObject( $data ){

        $this->load->model("articles_model");

        $createObject = $this->articles_model->postObject( $data );

        if( $createObject['success'] )
            redirect(base_url().'articles/?id='.$createObject['id'].'&format=json');

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $createObject['error'] );

        }

    }

    public function getObject_json( $id ){

        $this->load->model("articles_model");

        $carregarObjecto = $this->articles_model->getObject($id);

        if( $carregarObjecto["success"] ){ // se a consulta ao banco for bem sucedida

            nl2br($carregarObjecto["object"]->content);

            $res = $carregarObjecto["object"]; // insere o objeto na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarObjecto["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarObjecto["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function deleteObject( $id ){

        $this->load->model("articles_model");

        $deletarObjeto = $this->articles_model->deleteObject($id);

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

        $this->load->model("articles_model");

        $patchObject = $this->articles_model->patchObject( $id, $data );

        if( $patchObject['success'] ){

            redirect(base_url().'articles?id='.$id.'&format=json', 'location', 303);

        }

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $patchObject['error'] );

        }

    }
}