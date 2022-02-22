<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ==============================
 * CSVReader
 *
 * @package : CodeIgniter 3.x
 * @category : Libraries
 * @version : 1.0
 * @author : TechArise
 * ==============================
 */    
class CSVReader {
    // columns names retrieved after parsing
    private $fields;
    // separator used to explode each line
    private $separator = ';';
    // enclosure used to decorate each field
    private $enclosure = '"';
    // maximum row size to be used for decoding
    private $max_row_size = 4096;
   
    function parse_csv($filepath){        
        // Checking whether a file exists or not
        if(!file_exists($filepath)){
            return FALSE;            
        }        
        // The fopen() function opens a file or URL.
        $csvFileName = fopen($filepath, 'r');
        
        // Get Fields and values
        $this->fields = fgetcsv($csvFileName, $this->max_row_size, $this->separator, $this->enclosure);
        $keys_values = explode(',', $this->fields[0]);
        $keys = $this->escape_string($keys_values);
        
        // Store CSV data in an array
        $csvData = array();
        $count = 1;
        while(($row = fgetcsv($csvFileName, $this->max_row_size, $this->separator, $this->enclosure)) !== FALSE){
            // Skip empty lines
            if($row != NULL){
                $values = explode(',', $row[0]);
                if(count($keys) == count($values)){
                    $arr        = array();
                    $new_values = array();
                    $new_values = $this->escape_string($values);
                    for($j = 0; $j < count($keys); $j++){
                        if($keys[$j] != ""){
                            $arr[$keys[$j]] = $new_values[$j];
                        }
                    }
                    $csvData[$count] = $arr;
                    $count++;
                }
            }
        }
        // The fclose() function closes an open file.
        fclose($csvFileName);        
        return $csvData;
    }
    // escape string
    function escape_string($data){
        $result = array();
        foreach($data as $row){
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }   
}
?>