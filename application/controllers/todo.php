<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Todo extends My_Controller {

    public function index(){ $this->rest(); }

    public function getObjects_html() {

        $data = array();

        $conteudo = $this->load->view('todo/index', $data, true);

        $css_files = array('third-party/typeahead/typeahead-bootstrap3-fix', 'third-party/bootstrap-datepicker/bootstrap-datepicker');

        $js_files = array('js/bostag', 'js/todo', 'third-party/bostable/src/bostable', 'third-party/typeahead/typeahead', 'third-party/bootstrap-datepicker/bootstrap-datepicker', 'third-party/bootstrap-datepicker/bootstrap-datepicker.pt-BR');

        $this->template->load($conteudo, $js_files, $css_files, null); // carrega a pagina inicial

    }

    public function getObjects_json($filter){

        $page = isset($filter['page']) ? $filter['page'] : 1;

        $limit = isset($filter['limit']) ? $filter['limit'] : 30;

        $this->load->model("todo_model");

        $wishes = $this->todo_model->getObjects(false, $page, $limit, true);

        header('X-Total-Count: ' . $wishes['total']);

        header('Content-Type: application/json');

        echo json_encode($wishes['digest']);

    }

    public function createForm(){

        $this->load->view("todo/createForm");

    }

    public function readTemplate(){

        $this->load->view("todo/readTemplate");

    }

    public function updateForm(){

        $this->load->view("todo/updateForm");

    }

    public function deleteForm(){

        $this->load->view("todo/deleteForm");

    }

    public function postObject( $data ){

        $this->load->model("todo_model");

        $createObject = $this->todo_model->postObject( $data );

        if( $createObject['success'] )
            redirect(base_url().'todo/?id='.$createObject['id'].'&format=json');

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $createObject['error'] );

        }

    }

    public function getObject_json( $id ){

        $this->load->model("todo_model");

        $carregarObjecto = $this->todo_model->getObject($id);

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

        $this->load->model("todo_model");

        $deletarObjeto = $this->todo_model->deleteObject($id);

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

        $this->load->model("todo_model");

        $patchObject = $this->todo_model->patchObject( $id, $data );

        if( $patchObject['success'] ){

            redirect(base_url().'todo?id='.$id.'&format=json', 'location', 303);

        }

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $patchObject['error'] );

        }

    }
}