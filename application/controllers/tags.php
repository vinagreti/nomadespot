<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends My_Controller {

	public function index(){ $this->rest(); }

    public function getObjects_json( $params ){

    	$this->load->model("tags_model");

    	$tags = $this->tags_model->getObjects( $params );

    	header('Content-Type: application/json');

    	echo json_encode($tags['digest']);

    }

    public function postObject( $data ){

        $this->load->model("tags_model");

        $createObject = $this->tags_model->postObject( $data );

        if( $createObject['success'] )
            redirect(base_url().'tags/?id='.$createObject['id'].'&format=json');

        else{

            header( "HTTP/1.0 400");

            header('Content-Type: application/json');

            echo json_encode( $createObject['error'] );

        }

    }

    public function getObject_json( $id ){

        $this->load->model("tags_model");

        $carregarObjecto = $this->tags_model->getObject($id);

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

        $this->load->model("tags_model");

        $deletarObjeto = $this->tags_model->deleteObject($id);

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