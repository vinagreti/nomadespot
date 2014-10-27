<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inspirations_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['title']))
                $this->db->like('LOWER(inspirations.title)', strtolower($params['title']));

        }

        $this->db->select('inspirations.id');
        $this->db->select('inspirations.title');
        $this->db->select("SUBSTRING(inspirations.desc, 1, 50) as short_desc", FALSE);
        $this->db->select('inspirations.creation_date');
        $this->db->select('inspirations.link');
        $this->db->select('countries.name as country_name');
        $this->db->join('countries', 'countries.id = inspirations.country_id', 'left');
        $this->db->order_by('inspirations.id', 'DESC');
        $this->db->from('inspirations');

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
                    , "msg" => "Erro ao carregar digest das inspirações. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

    public function postObject( $data ){

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Título', 'required|is_unique[inspirations.title]');

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
                'title' => $data['title']
                , 'desc' => $data['desc']
                , 'link' => $data['link']
                , 'country_id' => $data['country_id']
            );

            $this->db->insert('inspirations', $data); 

            if(isset($data['tags'])){

                $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

                $this->load->model('tags_model');

                $this->tags_model->tagObject($tags, $id, 'inspirations');

            }

            $id = $this->db->insert_id();

            $res = array(
                "success" => true
                , "id" => $id
            );
        }

        return $res;

    }

    public function getObject( $id ){

        $this->db->select('inspirations.id');
        $this->db->select('inspirations.title');
        $this->db->select('inspirations.desc');
        $this->db->select('inspirations.creation_date');
        $this->db->select('inspirations.link');
        $this->db->select('countries.name as country_name');
        $this->db->join('countries', 'countries.id = inspirations.country_id', 'left');
        $this->db->where('inspirations.id', $id);
        $this->db->from('inspirations');

        $object =  $this->db->get()->row();

        $this->load->model('tags_model');

        $object->tags = $this->tags_model->objectTags($id, 'inspirations');

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar inspiração. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->delete('inspirations');

        $this->load->model('tags_model');
        $this->tags_model->removeObjectTags($id, 'inspirations');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Inspiração removida com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover inspiração. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }

    public function patchObject($id, $data){

        $wish = array();
        $atualizado = true;

        if(isset($data['title'])) $wish['title'] = $data['title'];
        if(isset($data['desc'])) $wish['desc'] = $data['desc'];
        if(isset($data['link'])) $wish['link'] = $data['link'];
        if(isset($data['country_id'])) $wish['country_id'] = $data['country_id'];

        if(count($wish) > 0){

            $this->db->where('id', $id);

            $atualizado = $this->db->update('inspirations', $wish);

        }

        if(isset($data['tags'])){

            $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

            $this->load->model('tags_model');

            $this->tags_model->tagObject($tags, $id, 'inspirations');

        }

        if($atualizado){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Inspiração removida com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao editar inspiração. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }
}
