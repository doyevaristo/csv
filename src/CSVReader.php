<?php

namespace Doyevaristo;

class CSVReader{

    protected $filepath;
    protected $datarows = array();
    protected $length = 0;
    protected $separator = ",";
    protected $enclosure = "\"";
    protected $headers;
    protected $autoDetectDelimeter = TRUE;

    public function __construct($filepath=null){

        if(!is_null($filepath)){$this->filepath = $filepath;}

    }

    public function useFirstRowAsHeader(){
        $this->useAsHeader(0);
    }

    public function useAsHeader($index){
       if(isset($this->datarows[$index])){
           $this->headers = $this->datarows[$index];
           $this->updateDataKeys();
           unset($this->datarows[$index]);
       }
       return $this;
    }

    private function updateDataKeys(){
        $newDatarows=array();

        foreach($this->datarows as $index=>$datarow){
            foreach($this->headers as $field=>$key){
                $newDatarow[$key] = $datarow[$field];
            }
            $newDatarows[] = $newDatarow;
        }

        $this->datarows = $newDatarows;


        return $this;

    }


    public function setHeader($headers = array()){
        $this->headers = $headers;
        return $this;
    }

    public function setEnclosure($enclosure){
        $this->enclosure = $enclosure;
        return $this;
    }

    public function setSeparator($separator){
        $this->separator = $separator;
        return $this;
    }

    public function setMaxRowContent($length){
        $this->length = $length;
        return $this;
    }

    public function file($filepath){
        $this->filepath = $filepath;

        if($this->autoDetectDelimeter){
            $this->separator = $this->_detectDelimeter();
            $this->enclosure = $this->_detectEnclosure();
        }

        return $this;
    }

    public function load($filepath=null,$separator=null,$enclosure=null){

        if(!is_null($separator)){ $this->setSeparator($separator); }
        if(!is_null($enclosure)){ $this->setEnclosure($enclosure); }
        if(!is_null($filepath)){ $this->file($filepath); }

        $this->_geFileData($this->filepath);

        return $this;
    }

    public function getDataRows(){
        return $this->datarows;
    }



    private function _geFileData(){

        if(!file_exists($this->filepath) || !is_readable($this->filepath)) return false;

        if (($csvHandler = fopen($this->filepath, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($csvHandler, $this->length, $this->separator,$this->enclosure)) !== FALSE)
            {
                $this->datarows[] = $row;
            }
            fclose($csvHandler);
        }

        return $this;
    }

    private function _detectDelimeter()
    {
        $delimiters = array(
            ';' => 0,
            ',' => 0,
            "\t" => 0,
            "|" => 0
        );

        $handle = fopen($this->filepath, "r");
        $firstLine = fgets($handle);
        fclose($handle);
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }

        return array_search(max($delimiters), $delimiters);
    }

    private function _detectEnclosure()
    {
        $enclosures = array(
            '"' => 0,
            "'" => 0,
        );

        $handle = fopen($this->filepath, "r");
        $firstLine = fgets($handle);
        fclose($handle);
        foreach ($enclosures as $enclosure => &$count) {
            $count = count(str_getcsv($firstLine, $enclosure));
        }

        return array_search(max($enclosures), $enclosures);
    }
}