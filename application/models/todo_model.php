<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Todo_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['title']))
                $this->db->like('LOWER(todo.title)', strtolower($params['title']));

        }

        $this->db->select('todo.id');
        $this->db->select('todo.title');
        $this->db->select("SUBSTRING(todo.desc, 1, 50) as short_desc", FALSE);
        $this->db->select('todo.deadline');
        $this->db->select('todo.status');
        $this->db->select('countries.name as country_name');
        $this->db->select('todo.user_id');
        $this->db->select('users.name as user_name');
        $this->db->join('users', 'users.id = todo.user_id', 'left');
        $this->db->join('countries', 'countries.id = todo.country_id', 'left');
        $this->db->order_by('todo.id', 'DESC');
        $this->db->from('todo');

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
                    , "msg" => "Erro ao carregar digest das tarefas. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

    public function postObject( $data ){

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Título', 'required|is_unique[todo.title]');

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
                , 'deadline' => $data['deadline']
                , 'status' => $data['status']
                , 'country_id' => is_int($data['country_id']) ? $data['country_id'] : ""
                , 'user_id' => $data['user_id']
            );

            $this->db->insert('todo', $data); 

            if(isset($data['tags'])){

                $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

                $this->load->model('tags_model');

                $this->tags_model->tagObject($tags, $id, 'todo');

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

        $this->db->select('todo.id');
        $this->db->select('todo.title');
        $this->db->select('todo.desc');
        $this->db->select("SUBSTRING(todo.desc, 1, 50) as short_desc", FALSE);
        $this->db->select('todo.deadline');
        $this->db->select('todo.status');
        $this->db->select('todo.country_id');
        $this->db->select('countries.name as country_name');
        $this->db->select('todo.user_id');
        $this->db->select('users.name as user_name');
        $this->db->join('users', 'users.id = todo.user_id', 'left');
        $this->db->join('countries', 'countries.id = todo.country_id', 'left');
        $this->db->where('todo.id', $id);
        $this->db->from('todo');

        $object =  $this->db->get()->row();

        $this->load->model('tags_model');

        $object->tags = $this->tags_model->objectTags($id, 'todo');

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar tarefa. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->delete('todo');

        $this->load->model('tags_model');
        $this->tags_model->removeObjectTags($id, 'todo');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Tarefa removida com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover tarefa. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }

    public function patchObject($id, $data){

        $todo = array();
        $atualizado = true;

        if(isset($data['title'])) $todo['title'] = $data['title'];
        if(isset($data['desc'])) $todo['desc'] = $data['desc'];
        if(isset($data['deadline'])) $todo['deadline'] = $data['deadline'];
        if(isset($data['status'])) $todo['status'] = $data['status'];
        if(isset($data['country_id'])) $todo['country_id'] = $data['country_id'];
        if(isset($data['user_id'])) $todo['user_id'] = $data['user_id'];

        if(count($todo) > 0){

            $this->db->where('id', $id);

            $atualizado = $this->db->update('todo', $todo);

        }

        if(isset($data['tags'])){

            $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

            $this->load->model('tags_model');

            $this->tags_model->tagObject($tags, $id, 'todo');

        }

        if($atualizado){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Tarefa removida com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao editar tarefa. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }
}
