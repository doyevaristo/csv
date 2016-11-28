<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once __DIR__."/../vendor/autoload.php";

use Doyevaristo\CSVReader;

$csvreader = new CSVReader();

$csvreader
    ->file(__DIR__."/datasource.csv")
    ->load()
    ->useFirstRowAsHeader();

print_r($csvreader->getDataRows());



