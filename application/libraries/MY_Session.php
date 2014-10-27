<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Evitando a expiração da sessão ao realizar chamadas ajax */
class MY_Session extends CI_Session {

    /**
     * sess_update()
     *
     * @access    public
     * @return    void
     */
    public function sess_update()
    {
        $CI =& get_instance();

        if ( ! $CI->input->is_ajax_request() )
        {
            parent::sess_update();
        }
    }
}