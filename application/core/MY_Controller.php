<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller{

    public function __construct() {

        parent::__construct(); // executa o construturo da classe pai

        $this->verificaAutenticacao(); // executa o método verificaAutenticacao()

    }

    private function verificaAutenticacao(){ // verifica se o usuario está tentando utilizar algum modulo sem estar autenticado

        $controles['publicos'] = array(
            'donate/index'
            , 'welcome/index'
            , 'articles/index'
            , 'currency/index'
            , 'images/index'
            , 'contact/index'
            , 'sponsorship/index'
            , 'car/index'
            , 'crew/index'
            , 'itinerary/index'
            , 'contact/index'
            , 'accounting/index'
            , 'wishlist/index'
            , 'inspirations/index'
            , 'hostus/index'
            , 'security/login'
            , 'security/retrievePassword'
            , 'services/index'
            , 'project/index'
        );

        if( ! $this->session->userdata("logged") ){ // se não estiver logado

            if(  ! in_array($this->router->class . '/' . $this->router->method, $controles['publicos']) ){ // e estiver acessando um conteúdo privado

                redirect(base_url()."login?redirect_url=".current_full_url()); // redireicona para a tela de login

            }

        } else {

            $this->load->model("security_model"); // carrega o modulo de segurança

            $this->security_model->atualizaSessaoUsuario(); // atualiza sessao do usuario

        }

    }

    public function rest(){ // rest server

        switch ($this->input->server('REQUEST_METHOD')) { // verifica o tipo de requisição HTTP

            case 'GET': // no caso de uma requisição de tipo GET

                $object_id = $this->input->get("id"); // salva o id da uri

                $format = $this->input->get("format");

                $output_formats = array(
                    "json"
                    , "html"
                );

                $output_format = (!empty($format) && in_array($format, $output_formats)) ? $format : 'html'; // salva o formato da resposta

                if($this->session->userdata('logged')){

                    if( $output_format == 'json' ) // se for uma reuisição AJAX
                        // se houver id executa o método getObject_json($id) e se não houver executa o método getObjects_json()
                        ($object_id !== false) ? $this->getObject_json( $object_id ) : $this->getObjects_json( $this->input->get() );

                    else // se não for uma requisição AJAX
                        // se houver id executa o método getObject_html($id) e se não houver executa o método getObjects_html()
                        ($object_id !== false) ? $this->getObject_html( $object_id ) : $this->getObjects_html( $this->input->get() );

                } else {

                    if( $output_format == 'json' ) // se for uma reuisição AJAX
                        // se houver id executa o método getPublicObject_json($id) e se não houver executa o método getPublicObjects_json()
                        ($object_id !== false) ? $this->getPublicObject_json( $object_id ) : $this->getPublicObjects_json( $this->input->get() );

                    else // se não for uma requisição AJAX
                        // se houver id executa o método getPublicObject_html($id) e se não houver executa o método getPublicObjects_html()
                        ($object_id !== false) ? $this->getPublicObject_html( $object_id ) : $this->getPublicObjects_html( $this->input->get() );

                }

            break;

            case 'POST': // no caso de uma requisição de tipo POST

                $this->postObject( $_POST ); // executa o método postObject($params);

            break;

            case 'PUT': // no caso de uma requisição de tipo PUT

                $object_id = $this->input->get("id"); // salva o id da uri

                parse_str(file_get_contents("php://input"),$post_vars);

                $_POST = $post_vars; // hack para poder utilizar o form validation

                $this->putObject($object_id, $post_vars ); // executa o método putObject($params);

            break;

            case 'PATCH': // no caso de uma requisição de tipo PATCH

                $object_id = $this->input->get("id"); // salva o id da uri

                parse_str(file_get_contents("php://input"),$post_vars);

                $_POST = $post_vars; // hack para poder utilizar o form validation

                $this->patchObject($object_id, $post_vars ); // executa o método patchObject($params);

            break;

            case 'DELETE': // no caso de uma requisição de tipo DELETE

                $this->deleteObject( $this->input->get('id') ); // executa o método deleteObject($params);

            break;

            default: // no caso de uma requisição de outros tipos

                show_error(htmlentities("Requisição inválida")); // retorna um erro

            break;

        }

    }
}