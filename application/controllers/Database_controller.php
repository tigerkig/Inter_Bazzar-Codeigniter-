<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_controller extends Admin_Core_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
       	$this->load->model('database_model');    
       	$this->load->helper(array('form', 'url'));
    }
		

	//  public function index() { 
    //      $this->load->view('upload_form', array('error' => ' ' )); 
    //   } 
	
    public function displaydata()
    {
		$result['data']=$this->Database_backup_model->display_records();
		$this->load->view('display_records',$result);
    }
    /*Delete Record*/
   	public function deletedata($id)
   	{
		$dbData = $this->database_model->get_db_data($id);
		$file_name = 'backups/database/'.$dbData->file_name;
		$this->load->helper("file");
		delete_files($file_name);
		$this->database_model->deleterecords($id);
		redirect($_SERVER['HTTP_REFERER']);
    }
    /*Delete Record*/
   	public function rollbackBackup($id)
   	{
		$dbData = $this->database_model->get_db_data($id);
		$file_name = FCPATH.'backups/database/'.$dbData->file_name;
		$lines = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		//echo '<pre>'; print_r($lines); die;
		$buffer = '';
		foreach ($lines as $line) {
			if (substr(ltrim($line), 0, 2) == '--' || $line[0]=='#')
				continue;
			if (($line = trim($line)) == ''){
				continue;
			}
			else if($line[strlen($line)-1] !=";"){
				$buffer .= $line;
				continue;
			}
			else
				if ($buffer) {
					$line = $buffer . $line;
					$buffer = '';
				}
			$this->db->query($line);
			//$result = @mysqli_query($link, $line) or die(mysqli_error($link).$line);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }


    /*Rollback Backup*/
   	public function rollbackBackup_upload()
   	{
		   $dbData = $this->input->post('uploadFile');
   		if ($this->input->post('uploadFile')) {
			$file_name = FCPATH.'backups/database/'.$dbData;
			$lines = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			//echo '<pre>'; print_r($lines); die;
			$buffer = '';
			foreach ($lines as $line) {
				if (substr(ltrim($line), 0, 2) == '--' || $line[0]=='#')
					continue;
				if (($line = trim($line)) == ''){
					continue;
				}
				else if($line[strlen($line)-1] !=";"){
					$buffer .= $line;
					continue;
				}
				else
					if ($buffer) {
						$line = $buffer . $line;
						$buffer = '';
					}
				$this->db->query($line);
				$result = @mysqli_query($link, $line) or die(mysqli_error($link).$line);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
    }

    //  public function do_upload(){
	//     $config = array();
	//     $config['upload_path'] = FCPATH.'backups/database/';
	//     $config['allowed_types'] = '*'; //'gif|jpg|png';
	//     $config['encrypt_name']  = TRUE;
	//     //$config['max_size'] = 100;
	//     //$config['max_width'] = 1024;
	//     //$config['max_height'] = 768;
	//     $this->load->library('upload',$config);
	//     if ( ! $this->upload->do_upload('fileForUpload')) {
	//         $error = array('error' => $this->upload->display_errors());
	//         //Action, in case file upload failed
	//     } else {
	//         //Action, after file successfully uploaded
	//     }
	// }





	public function do_upload() { 
		$config['upload_path']   = './uploads/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size']      = 100; 
		$config['max_width']     = 1024; 
		$config['max_height']    = 768;  
		$this->load->library('upload', $config);
		   
		if ( ! $this->upload->do_upload('fileForUpload')) {
		   $error = array('error' => $this->upload->display_errors()); 
		   $this->load->view('upload_form', $error); 
		}
		   
		else { 
		   $data = array('upload_data' => $this->upload->data()); 
		   $this->load->view('upload_success', $data); 
		} 
	 } 
}