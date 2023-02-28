<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unidades_model extends CI_Model
{
    // Logica para trazer TODAS as Unidades do BD
    public function buscaUnidades()
    {
        $query = $this->db->get_where('unidades', array('ativo' => 1))->result_array();;

        return $query;
    }
}
