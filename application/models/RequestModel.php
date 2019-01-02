<?php
/**
 * Created by PhpStorm.
 * User: pinje
 * Date: 12/31/18
 * Time: 1:31 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class requestmodel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function update($where,$data,$table)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    public function save($data,$table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    // insert
    function insert($table,$data)
    {
        return $this->db->insert($table, $data);
    }

}