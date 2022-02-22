<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_model extends CI_Model 
{

    /*
    *-------------------------------------------------------------------------------------------------
    * Database backup 
    *-------------------------------------------------------------------------------------------------
    */

    /*Display*/
    function display_records()
    {
		$query=$this->db->query("select * from db_backup");
		return $query->result();
    }
	
    function get_db_data($id)
    {
		$sql = "SELECT * FROM db_backup WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }
   /*Delete*/
    function deleterecords($id)
    {
    	$this->db->query("delete from db_backup where id='".$id."'");
    }
}