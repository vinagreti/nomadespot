<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template
{

  function __construct()
  {
     $this->CI =& get_instance();
  }

  public function load($content, $arquivos_js = array(), $arquivos_css = array() ){

    $template_data = new stdClass();

    $template_data->content = $content;

    $template_data->arquivos_css = $arquivos_css;

    $template_data->arquivos_js = $arquivos_js;

    $template = $this->CI->session->userdata("logged") ? 'private' : 'public';

    $this->CI->load->view("templates/$template", $template_data);

  }

}