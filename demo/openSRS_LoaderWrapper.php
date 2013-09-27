<?php
require_once __DIR__ . '/../opensrs/openSRS_loader.php';

// Call parsers and functions of openSRS
function processOpenSRS ($type="", $data="") {

    if (empty($data)) {
        trigger_error("OSRS Error - No data found.");
        return null;
    }
    else {
        $dataArray = array();
        switch(strtolower($type)) {
            case "array":
                $dataArray = $data;
                break;
            case "json":
                $json = str_replace("\\\"", "\"", $data);   //  Replace  \"  with " for JSON that comes from Javascript
                $dataArray = json_decode($json, true);
                break;
            case "yaml":
                $dataArray = Spyc::YAMLLoad($data);
                break;
            default:
                $dataArray = $data;
        }
        // Convert associative array to object
        $dataObject = array2object($dataArray);
        $classCall = null;
        if (class_exists($dataObject->func)){
            $classCall = new $dataObject->func($type, $dataObject);
        }
        else {
            trigger_error("OSRS Error - Unable to find the function $dataObject->func.  Either the function is misspelled or there are incorrect file paths set in openSRS_config.php.");
        }
        return $classCall;
    }
}

function array2object($data) {
    if(!is_array($data)) return $data;
    $object = new stdClass();

    foreach ($data as $name=>$value) {
        if (isset($name)) {
            $name = strtolower(trim($name));
            $object->$name = array2object($value);
        }
    }
    return $object;
}

function object2array($data){
    if(!is_object($data) && !is_array($data)) return $data;
    if(is_object($data)) $data = get_object_vars($data);
    return array_map('object2array', $data);
}

function convertArray2Formatted ($type="", $data="") {
    $resultString = "";
    if ($type == "json") $resultString = json_encode($data);
    if ($type == "yaml") $resultString = Spyc::YAMLDump($data);
    return $resultString;
}

function convertFormatted2array ($type="", $data="") {
    $resultArray = "";
    if ($type == "json") $resultArray = json_decode($data, true);
    if ($type == "yaml") $resultArray = Spyc::YAMLLoad($data);;
    return $resultArray;
}

function array_filter_recursive($input)
{
    foreach ($input as &$value)
    {
        if (is_array($value))
        {
            $value = array_filter_recursive($value);
        }
    }
    return array_filter($input);
}