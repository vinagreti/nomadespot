<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['name']))
                $this->db->like('LOWER(users.name)', strtolower($params['name']));

        }

        $this->db->select('users.id');
        $this->db->select('users.client_id');
        $this->db->select('users.name');
        $this->db->select('users.email');
        $this->db->select('users.last_login');
        $this->db->from('users');

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
                    , "msg" => "Erro ao carregar digest dos usuários. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

}