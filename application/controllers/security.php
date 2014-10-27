<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security extends MY_Controller {

    public function index()
    {

        redirect(base_url());

    }

    public function login(){

        if( $this->session->userdata("logged") ) redirect(base_url());

        if( ! $this->input->post() ){

            $javascript = array( "js/security" );
           
            $content = $this->load->view('security/login', false, true);

            $this->template->load($content, $javascript, null, null);

        } else {

            $this->load->model("security_model");

            $login = $this->security_model->login( $this->input->post() );

            if( $login["success"] )
                $res = base_url()."dashboard";

            else {

                $res = $login["msg"];

                header( "HTTP/1.0 400 ". utf8_decode( $res ) );

            }

            header('Content-Type: application/json');

            echo json_encode( $res );

        }

    }

    public function logout(){

        if( ! $this->session->userdata("logged") )
            redirect(base_url());

        $this->session->sess_destroy();

        redirect(base_url()."login");

    }

    public function retrievePassword(){

        if( $this->session->userdata("logged") )
            redirect(base_url());

        if( ! $this->input->post() ){

            $javascript = array(
                "js/security"
            );

           
            $content = $this->load->view('security/retrievePassword', false, true);

            $this->template->load($content, $javascript, null, null);

        } else{

            $this->load->model("security_model");

            $retrievePassword = $this->security_model->retrievePassword( $this->input->post() );

            if( $retrievePassword["success"] ){

                $res = $retrievePassword["msg"];

            } else {

                $res = $retrievePassword["msg"];

                header( "HTTP/1.0 400 ". utf8_decode( $res ) );

            }

            header('Content-Type: application/json');

            echo json_encode( $res );

        }

    }

    public function changePassword(){

        if( ! $this->input->post() ){

            $javascript = array(
                "js/event/we_security_evento"
                , "js/model/we_security_model"
                , "js/view/we_security_view"
                , "js/controller/we_security_controller"
            );

            if( $this->session->userdata("logged") ){

                $conteudo = $this->load->view('security/changePassword', false, true);

                $this->template->load($conteudo, $javascript, null, null);

            } else if( $_GET["token"] ){

                $this->load->model("security_model");

                $token_exist_res = $this->security_model->verificaValidadeAlterarSenhaToken( $_GET["token"] );

                if( $token_exist_res["success"] ){

                    $conteudo = $this->load->view('security/changePassword', false, true);

                    $this->template->load($conteudo, $javascript, null, null);

                } else {

                    $conteudo = $this->load->view('security/tokenInvalido', false, true);
                   
                    $this->template->load($conteudo, null, null, null);

                }

            } else
                redirect(base_url());

        } else {

            $this->load->model("security_model");

            $changePassword = $this->security_model->changePassword( $this->input->post() );

            if( $changePassword["success"] ){

                $res = $changePassword["msg"];

            } else {

                $res = $changePassword["msg"];

                header( "HTTP/1.0 400 ". utf8_decode( $changePassword["msg"] ) );

            }

            header('Content-Type: application/json');

            echo json_encode( $res );

        }

    }

}