<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['name']))
                $this->db->like('LOWER(tags.name)', strtolower($params['name']));

        }

        $this->db->select('tags.id');
        $this->db->select('tags.name');
        $this->db->order_by('tags.name');
        $this->db->from('tags');

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
                    , "msg" => "Erro ao carregar digest dos países. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

    public function postObject( $data ){

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Nome', 'required|is_unique[tags.name]');

        if ($this->form_validation->run() == FALSE)
        {
            $res = array(
                "success" => false
                , "error" => $this->form_validation->error_array()
            );
        }
        else
        {
            $data = array(
                'name' => $data['name']
            );

            $this->db->insert('tags', $data); 

            $id = $this->db->insert_id();

            $res = array(
                "success" => true
                , "id" => $id
            );
        }

        return $res;

    }

    public function getObject( $id ){

        $this->db->select('tags.id');
        $this->db->select('tags.name');
        $this->db->where('tags.id', $id);
        $this->db->from('tags');

        $object =  $this->db->get()->row();

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar tag. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->delete('tags');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'tag removida com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover tag. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }

    public function objectTags($object_id, $object_table) {

        $this->db->select('tags.id');
        $this->db->select('tags.name');
        $this->db->order_by('tags.name');
        $this->db->from('tags');
        return $this->db->get()->result();

    }

    public function tagObject($tags, $object_id, $object_table) {

        foreach($tags as $index => $tag_id) {

            $data = array(
                'tag_id' => $tag_id
                , 'object_id' => $object_id
                , 'object_table' => $object_table
            );

            $this->db->insert('tagged_objects', $data);

        }

    }

    public function removeObjectTags($object_id, $object_table) {

        $this->db->where('object_id', $object_id); // remove o usuario do banco
        $this->db->where('object_table', $object_table); // remove o usuario do banco
        return $this->db->delete('tagged_objects');

    }

}