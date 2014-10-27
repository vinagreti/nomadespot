<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Model extends CI_Model {

    public function login( $params ){

        if( isset( $params["email"] ) && $params["email"] != "" && isset( $params["password"] ) && $params["password"] != "" ){

            $this->db->select("users.id, users.name, users.email, clients.id as client_id, clients.name as client_name");

            $this->db->select("DATE_FORMAT(users.last_login, '%d-%m-%Y %H:%i:%s') as last_login", FALSE);  

            $this->db->where( "email", $params["email"] );

            $this->db->where( "password", md5( $params["password"] ) );

            $this->db->join('clients', 'clients.id = users.client_id');

            $user = $this->db->get("users")->row();

            if( $user ){

                $this->db->where("id", $user->id);

                $this->db->set("last_login", "now()", false);

                $this->db->update('users');

                $this->session->set_userdata("logged", true);

                $this->session->set_userdata("id", $user->id);

                $this->session->set_userdata("name", $user->name);

                $this->session->set_userdata("email", $user->email);

                $this->session->set_userdata("last_login", $user->last_login);

                $this->session->set_userdata("client_id", $user->client_id);

                $this->session->set_userdata("client_name", $user->client_name);

                $res = array(
                    "success" => true
                    , "user" => $user
                    , "msg" => "OK"
                );

            } else {

                $res = array(
                    "success" => false
                    , "msg" => "E-mail e senha não conferem."
                );

            }

        } else {

            $res = array(
                "success" => false
                , "msg" => "Informe o email e senha para eftuar login."
            );

        }

        return $res;

    }

    public function retrievePassword( $params ){

        if( isset( $params["email"] ) && $params["email"] != "" ){

            $this->db->where( "email", $params["email"] );

            $usuario = $this->db->get("users")->row();

            if( $usuario ){

                $this->db->where("dat_utilizacao", "0000-00-00 00:00:00");
                $this->db->where("cod_cliente_contato", $usuario->ide_cliente_contato);
                $update = $this->db->update( 'we_reset_senha_token', array("dat_utilizacao" => date( 'Y-m-d H:i:s' ) ) );

                $token = md5(uniqid());

                $data = array(
                    'dsc_token' => $token
                    , 'cod_cliente_contato' => $usuario->ide_cliente_contato
                    , 'dat_criacao' => date( 'Y-m-d H:i:s' )
                    , 'dat_vencimento' => date( 'Y-m-d H:i:s', strtotime("+1 day") )
                );

                $this->db->insert('we_reset_senha_token', $data);

               
                $mensagem = "Olá " . $usuario->nom_contato . ",";
                $mensagem .= "\r\n<p> Recebemos uma solicitação de alteração de senha.</p>";
                $mensagem .= "\r\n<p> Caso tenha solicitado a alteração, clique no link abaixo para criar uma nova senha:</p>";
                $mensagem .= "\r\n<p>" . base_url() . "alterarSenha/?token=$token.</p>";
                $mensagem .= "\r\n<p> Caso não tenha solicitado a alteração, apenas ignore este e-mail.</p>";
                $mensagem .= "\r\n<p> Atenciosamente,</p>";
                $mensagem .= "\r\n<p> We Crowdcasting</p>";

                $this->load->library('email');
                $this->email->from('no-reply@wecrowdcasting.com', 'Console WE Crowdcasting');
                $this->email->to( $params["email"] ); 
                $this->email->subject('Recuperação de senha');
                $this->email->message( $mensagem ); 
                $this->email->send();

                $res = array(
                    "success" => true
                    , "msg" => "Um link de recuperacao de senha foi enviado para o email <strong>". $params["email"] ."</strong>. Você tem até 24 horas pára utilizá-lo."
                );

            } else {

                $res = array(
                    "success" => false
                    , "msg" => "O e-mail ".$params["email"]." não está cadastrado."
                );

            }

        } else {

            $res = array(
                "success" => false
                , "msg" => "Informe seu email para recuperar sua senha."
            );

        }

        return $res;

    }

    public function alterarSenha( $params ){

        if( $params["senha1"] == $params["senha2"] ){

            if( isset($_GET["token"]) ){

                $token_exist_res = $this->verificaValidadeAlterarSenhaToken( $_GET["token"] );

                if( $token_exist_res["success"] ){

                    $this->db->where("ide_reset_senha_token", $token_exist_res["token"]->ide_reset_senha_token);
                    $update = $this->db->update( 'we_reset_senha_token', array("dat_utilizacao" => date( 'Y-m-d H:i:s' ) ) );

                    $this->db->where("ide_cliente_contato", $token_exist_res["token"]->cod_cliente_contato);
                    $this->db->update( 'users', array("dsc_senha" => md5( $params["senha1"] ) ) );

                    $this->session->sess_destroy();

                    $res = array(
                        "success" => true
                        , "msg" => "Senha alterada com success."
                    );

                } else {

                    $res = $token_exist_res;

                }

            } else if ( $this->session->userdata("logged") ) {

                $this->db->where("ide_cliente_contato", $this->session->userdata("ide_cliente_contato"));
                $this->db->update( 'users', array("dsc_senha" => md5( $params["senha1"] ) ) );

                $res = array(
                    "success" => true
                    , "msg" => "Senha alterada com success."
                );

            }

        } else {

            $res = array(
                "success" => false
                , "msg" => "A nova senha e a confirmação da nova senha devem ser iguais."
            );

        }

        return $res;

    }

    public function verificaValidadeAlterarSenhaToken( $token ){

        $this->db->where( "dsc_token", $token );
        $token = $this->db->get("we_reset_senha_token")->row();

        if( $token ){

            if( $token->dat_utilizacao == "0000-00-00 00:00:00" ){

                if( $token->dat_vencimento >= date( 'Y-m-d H:i:s' ) ){

                    $res = array(
                        "success" => true
                        , "token" => $token
                    );

                } else {

                    $res = array(
                        "success" => false
                        , "msg" => "O token de recuperação de senha está vencido. Por favor, solicite novamente a recuperação de senha."
                    );

                }

            } else {

                $res = array(
                    "success" => false
                    , "msg" => "O token já foi utilizado ou outro token de recuperação de senha foi gerado."
                );

            }

        } else {

            $res = array(
                "success" => false
                , "msg" => "O token não existe."
            );

        }

        return $res;

    }

    public function atualizaSessaoUsuario(){

        $this->db->select("users.id, users.name, users.email, clients.id as client_id, clients.name as client_name");

        $this->db->select("DATE_FORMAT(users.last_login, '%d-%m-%Y %H:%i:%s') as last_login", FALSE);  

        $this->db->where( "users.id", $this->session->userdata("id") );

        $this->db->join('clients', 'clients.id = users.client_id');

        $user = $this->db->get("users")->row();

        $this->session->set_userdata("logged", true);

        $this->session->set_userdata("id", $user->id);

        $this->session->set_userdata("name", $user->name);

        $this->session->set_userdata("email", $user->email);

        $this->session->set_userdata("last_login", $user->last_login);

        $this->session->set_userdata("client_id", $user->client_id);

        $this->session->set_userdata("client_name", $user->client_name);

        return true;

    }

}