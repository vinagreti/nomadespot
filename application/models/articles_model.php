<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model {

    public function getObjects( $params = false, $page = false, $limit = false, $returnTotal = false, $count = false ){

        if( !empty($params) ){

            if(!empty($params['title']))
                $this->db->like('LOWER(articles.title)', strtolower($params['title']));

        }

        $this->db->select('articles.id');
        $this->db->select('articles.title');
        $this->db->select('articles.content');
        $this->db->select('articles.creation_date');
        $this->db->select('articles.last_update');
        $this->db->select('articles.slug');
        $this->db->select('media_kind');
        $this->db->select('media_src');
        $this->db->order_by('articles.id', 'DESC');
        $this->db->from('articles');

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
                    , "msg" => "Erro ao carregar digest dos artigos. Tente novamente mais tarde."
                );

            }

        }

        return $res;

    }

    private function getFirstMediaSrc($text) {

        $media = array();

        if($text == "") {

            $media['kind'] = "img";

            $media['src'] = "http://imagestore.nomadespot.com/600";

            return $media;

        } else {

            $doc = new DOMDocument();

            $doc->loadHTML($text);

            $xpath = new DOMXPath($doc);

            $img_pos = strpos($text, '<img');

            $iframe_pos = strpos($text, '<iframe');

            if ($img_pos > $iframe_pos) {

                $src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"

                $media['kind'] = "img";

                $media['src'] = $src;

            } else {

                $src = $xpath->evaluate("string(//iframe/@src)"); # "/images/image.jpg"

                $media['kind'] = "video";

                $media['src'] = $src;

            }

            return $media;

        }

    }

    public function postObject( $data ){

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Título', 'required|is_unique[articles.title]');

        if ($this->form_validation->run() == FALSE) {

            $res = array(
                "success" => false
                , "error" => $this->form_validation->error_array()
            );

        } else {

            $this->load->helper('slug');

            $_POST['slug'] = isset($data['title']) ? makeSlugs($data['title']) : null;

            $media = $this->getFirstMediaSrc($data['content']);

            $data = array(
                'title' => $data['title']
                , 'slug' => $_POST['slug']
                , 'content' => $data['content']
                , 'media_kind' => $media['kind']
                , 'media_src' => $media['src']
            );

            $this->db->insert('articles', $data); 

            $id = $this->db->insert_id();

            if(isset($data['tags'])){

                $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

                $this->load->model('tags_model');

                $this->tags_model->tagObject($tags, $id, 'articles');

            }

            $res = array(
                "success" => true
                , "id" => $id
            );
        }

        return $res;

    }

    public function getObject( $id ){

        $this->db->select('articles.id');
        $this->db->select('articles.title');
        $this->db->select('articles.content');
        $this->db->select('articles.creation_date');
        $this->db->select('articles.last_update');
        $this->db->select('articles.slug');
        $this->db->select('media_kind');
        $this->db->select('media_src');
        $this->db->where('articles.id', $id);
        $this->db->from('articles');

        $object =  $this->db->get()->row();

        $this->load->model('tags_model');

        $object->tags = $this->tags_model->objectTags($id, 'articles');

        if( $object ){

            $res = array(
                "success" => true
                , "object" => $object
            );

        } else {

            $res = array(
                "success" => false
                , "msg" => "Erro ao carregar artigo. Tente novamente mais tarde."
            );

        }

        return $res;

    }

    public function deleteObject( $id ){

        $this->db->where('id', $id); // remove o usuario do banco
        $removido = $this->db->delete('articles');

        $this->load->model('tags_model');
        $this->tags_model->removeObjectTags($id, 'articles');

        if($removido){
            $res = array( // define a resposta
                "success" => true // define como success
                , "msg" => 'Artigo removido com success' // insre o resumo
            );
        } else {
            $res = array( // define a resposta
                "success" => false // define como falha
                , "msg" => 'Problema ao remover artigo. Tente novamente mais tarde.' // insre o resumo
            );
        }

        return $res;

    }

    public function patchObject($id, $data){

        $article = array();
        $atualizado = true;

        if(isset($data['title'])) $article['title'] = $data['title'];

        if(isset($data['content'])) {

            $media = $this->getFirstMediaSrc($data['content']);

            $article['content'] = $data['content'];
            $article['media_kind'] = $media['kind'];
            $article['media_src'] = $media['src'];

        }

        $_POST['title'] = $data['title'];

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Título', 'required|is_unique[articles.title]');

        if(isset($data['updateSlug'])){

            $this->load->helper('slug');

            $article['slug'] = $_POST['slug'] = isset($data['title']) ? makeSlugs($data['title']) : null;
            
            $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[articles.slug]');

        }

        if ($this->form_validation->run() == FALSE) {

            $res = array(
                "success" => false
                , "error" => $this->form_validation->error_array()
            );

        } else {

            if(count($article) > 0){

                $this->db->where('id', $id);

                $this->db->set('last_update', 'NOW()', FALSE);

                $atualizado = $this->db->update('articles', $article);

            }

            if(isset($data['tags'])){

                $tags = is_array($data['tags']) ? $data['tags'] : array($data['tags']);

                $this->load->model('tags_model');

                $this->tags_model->tagObject($tags, $id, 'articles');

            }

            if($atualizado){
                $res = array( // define a resposta
                    "success" => true // define como success
                    , "msg" => 'Artigo removido com success' // insre o resumo
                );
            } else {
                $res = array( // define a resposta
                    "success" => false // define como falha
                    , "msg" => 'Problema ao remover artigo. Tente novamente mais tarde.' // insre o resumo
                );
            }

        }


        return $res;

    }

}
