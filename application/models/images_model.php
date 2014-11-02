<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model {

    private $bucket; // S3 Bucket
    private $folder; // images folder

    function __construct(){

        // set class variables
        $this->bucket = (ENVIRONMENT == 'production') ? 'nomadespot' : 'nomadespot-dev';
        $this->folder = 'uploads/images/';

    }

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['id']))
                $this->db->like('LOWER(images.id)', strtolower($params['id']));

            if(!empty($params['name']))
                $this->db->like('LOWER(images.name)', strtolower($params['name']));

            if(!empty($params['uri']))
                $this->db->like('LOWER(images.uri)', strtolower($params['uri']));

        }

        $this->db->select('images.id');
        $this->db->select('images.name');
        $this->db->select('images.uri');
        $this->db->select('images.desc');
        $this->db->select('images.private');
        $this->db->from('images');

        if( $limit ) {

            $this->db->limit( $limit );

            if( $page )
                $this->db->offset( ($page * $limit) - $limit );

        }

        if( $count ){

            $res = $this->db->count_all_results();

        } else {

            $digest = $this->db->get()->result();

            if( count($digest) >= 0 ){

                $res = array(
                    "success" => true
                    , "digest" => $digest
                );

                if( $returnTotal ){

                    $res["total"] = $this->getObjects($params, false, false, false, true);

                }

            } else {

                $res = array(
                    "success" => false
                    , "msg" => "Erro ao carregar digest dos desejos. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

    public function postObject( ){

        try {

            // Load Library
            $this->load->library('s3');

            $files = array();

            $desc = !empty($_POST['desc']) ? $_POST['desc'] : "";

            foreach($_FILES['images']['tmp_name'] as $index => $value){

                $tmp_name = $_FILES['images']['tmp_name'][$index];

                $name = $_FILES['images']['name'][$index];

                $name = preg_replace('/\s+/', '', $name);

                $aws_file_uri = $this->folder . md5(uniqid(rand(), true));

                $uri = 'http://' . $this->bucket . '.s3-sa-east-1.amazonaws.com/' . $aws_file_uri;

                if($this->s3->putObject($this->s3->inputFile($tmp_name), $this->bucket, $aws_file_uri, S3::ACL_PUBLIC_READ)){

                    $data = array(
                        'name' => $name
                        , 'uri' => $uri
                        ,  'desc' => $desc
                        , 'aws_file_uri' => $aws_file_uri
                    );

                    $this->db->insert('images', $data);

                    array_push($files, array('name' => $name, 'uri' => $uri, 'desc' => $_POST['desc'], 'id' => $this->db->insert_id()));

                }

            }

            $res["success"] = true;
            $res['files'] = $files;

            $res['msg'] = "Arquivos enviados com sucesso!";

        } catch (Exception $e) {

            $res = array(
                "success" => false
                , "msg" => 'Problemas ao enviar arquivos para o S3.'
            );

        }

        return $res;

    }

    public function getObject( $id ){

        $this->db->select('images.id');
        $this->db->select('images.name');
        $this->db->select('images.uri');
        $this->db->select('images.desc');
        $this->db->select('images.private');
        $this->db->where('images.id', $id);
        $this->db->from('images');

        $object =  $this->db->get()->row();

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar imagem. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('images.id', $id);
        $this->db->from('images');

        $object =  $this->db->get()->row();

        if(isset($object->aws_file_uri)){

            $this->db->where('id', $id); // remove o usuario do banco
            $removido = $this->db->delete('images');

            if($removido){

                // Load Library
                $this->load->library('s3');

                $this->s3->deleteObject($this->bucket, $object->aws_file_uri);

                $res = array( // define a resposta
                    "success" => true // define como success
                    , "msg" => 'Imagem removida com success' // insre o resumo
                );
            } else {
                $res = array( // define a resposta
                    "success" => false // define como falha
                    , "msg" => 'Problema ao remover imagem. Tente novamente mais tarde.' // insre o resumo
                );
            }

        } else {

            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover imagem. Imagem não encontrada.' // insre o resumo
            );

        }

        return $res;

    }

    public function patchObject( $id, $data ){

        if(isset($data['private'])) {

            $this->db->set('private', $data['private']);

        }

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->update('images');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Imagem atualizada com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover imagem. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }
}
