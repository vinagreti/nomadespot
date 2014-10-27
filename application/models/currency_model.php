<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        $this->ensureLatestRates();

        if( !empty($params) ){

            if(!empty($params['name']))
                $this->db->like('LOWER(currency.name)', strtolower($params['name']));

        }

        $this->db->select('currency.id');
        $this->db->select('currency.timestamp');
        $this->db->select('currency.rates');
        $this->db->from('currency');

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

    private function ensureLatestRates(){

        $this->db->select('currency.timestamp');
        $this->db->order_by('id', 'desc');
        $currency = $this->db->get('currency')->row();

        if(!$currency || $currency->timestamp < strtotime('00:00:00')) {// if the rates is not about today get a new from server

            $raw_currency = file_get_contents('http://openexchangerates.org/latest.json?app_id=c5ef387e3109435e89a61930d1770284');
            $data = json_decode($raw_currency);
            unset($data->disclaimer);
            unset($data->license);
            $currency = array(
                'timestamp' => $data->timestamp
                , 'rates' => json_encode($data)
            );

            $this->db->insert('currency', $currency);

        }

        return true;

    }

    public function getLatest(){

        $this->ensureLatestRates();

        $this->db->select('currency.timestamp');
        $this->db->select('currency.rates');
        $this->db->order_by('id', 'desc');
        $currency = $this->db->get('currency')->row();

        return $currency;
    }

}