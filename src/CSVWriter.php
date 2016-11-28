<?php

namespace Doyevaristo;

class CSVWriter{

    protected $data;
    protected $outfile;
    protected $document;
    protected $nullValue="\\N";
    protected $headers;

    public function __construct(){
    }


    public function addRow($datarow, $position){

    }

    public function prependRow(){}

    public function appendRow(){}

    public function removeRowByIndex($index){

    }

    public function nullValue($value){

    }

    public function dataFromArray($data){

    }

    public function setArrayKeysAsHeader(){

    }

    public function setHeader($headers){

    }

    public function setOutfile($outfile){

    }


    public function save($outfile=null){


    }
}