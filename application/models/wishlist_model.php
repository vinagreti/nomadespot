<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wishlist_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['title']))
                $this->db->like('LOWER(wishlist.title)', strtolower($params['title']));

        }

        $this->db->select('wishlist.id');
        $this->db->select('wishlist.title');
        $this->db->select("SUBSTRING(wishlist.desc, 1, 40) as short_desc", FALSE);
        $this->db->select('wishlist.coust');
        $this->db->select('wishlist.status');
        $this->db->select("REPLACE( REPLACE(wishlist.status, 0, 'Pendente') , 1, 'Realizado') as status_title", FALSE); 
        $this->db->select('countries.name as country_name');
        $this->db->join('countries', 'countries.id = wishlist.country_id', 'left');
        $this->db->order_by("wishlist.id", "desc");
        $this->db->from('wishlist');

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

    public function postObject( $data ){

        $this->load->helper('form');

        $this->load->library('form_validation');

        // validates form data
        $this->form_validation->set_rules('title', 'Título', 'required|is_unique[wishlist.title]');


        if ($this->form_validation->run() == FALSE) {

            $res = array(
                "success" => false
                , "error" => $this->form_validation->error_array()
            );

        } else {

            $wish = array();

            // mount wish object
            if(isset($data['title'])) $wish['title'] = $data['title'];
            if(isset($data['country_id'])) $wish['country_id'] = $data['country_id'];
            if(isset($data['coust'])) $wish['coust'] = $data['coust'];
            if(isset($data['desc'])) $wish['desc'] = $data['desc'];
            if(isset($data['status'])) $wish['status'] = $data['status'];
            if(isset($data['deadline'])){

                $date = DateTime::createFromFormat('d/m/Y H:i:s', $data['deadline']);

                if($date){

                    $wish['deadline'] = $date->format('Y-m-d');

                } else {

                    $wish['deadline'] = "";

                }

            }

            $this->db->insert('wishlist', $wish);

            $id = $this->db->insert_id();

            if(isset($data['tags'])){

                $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

                $this->load->model('tags_model');

                $this->tags_model->tagObject($tags, $id, 'wishlist');

            }

            $res = array(
                "success" => true
                , "id" => $id
            );
        }

        return $res;

    }

    public function getObject( $id ){

        $this->db->select('wishlist.id');
        $this->db->select('wishlist.title');
        $this->db->select('wishlist.desc');
        $this->db->select('wishlist.coust');
        $this->db->select('wishlist.status');
        $this->db->select("REPLACE( REPLACE(wishlist.status, 0, 'Pendente') , 1, 'Realizado') as status_title", FALSE); 
        $this->db->select('countries.name as country_name');
        $this->db->select('wishlist.country_id');
        $this->db->join('countries', 'countries.id = wishlist.country_id', 'left');
        $this->db->where('wishlist.id', $id);
        $this->db->from('wishlist');

        $object =  $this->db->get()->row();

        $this->load->model('tags_model');

        $object->tags = $this->tags_model->objectTags($id, 'wishlist');

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar desejo. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->delete('wishlist');

        $this->load->model('tags_model');
        $this->tags_model->removeObjectTags($id, 'wishlist');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Desejo removido com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover desejo. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }

    public function patchObject($id, $data){

        $wish = array();
        $atualizado = true;

        if(isset($data['title'])) $wish['title'] = $data['title'];
        if(isset($data['country_id'])) $wish['country_id'] = $data['country_id'];
        if(isset($data['coust'])) $wish['coust'] = $data['coust'];
        if(isset($data['desc'])) $wish['desc'] = $data['desc'];
        if(isset($data['status'])) $wish['status'] = $data['status'];
        if(isset($data['deadline'])){

            $date = DateTime::createFromFormat('d/m/Y', $data['deadline']);

            if($date){

                $wish['deadline'] = $date->format('Y-m-d');

            } else {

                $wish['deadline'] = null;

            }

        } 

        if(count($wish) > 0){

            $this->db->where('id', $id);

            $atualizado = $this->db->update('wishlist', $wish);

        }

        if(isset($data['tags'])){

            $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

            $this->load->model('tags_model');

            $this->tags_model->tagObject($tags, $id, 'wishlist');

        }

        if($atualizado){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Desejo removido com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover desejo. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }
}