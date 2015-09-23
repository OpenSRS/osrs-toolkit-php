<?php

namespace opensrs\backwardcompatibility\dataconversion;

use opensrs\Base;

class DataConversion extends Base
{
    /**
     * Method to convert original $data object
     * structure to match the structure that the
     * actual API uses
     * This is for backward compatibility with
     * older implementations that make use of
     * this toolkit. It will not be run on newer
     * implementations that send that data pre-
     * formatted in the new structure.
     */
    public function convertDataObject($dataObject, $newStructure)
    {
        // Run our data objects through the field conversion
        // method
        // We're only doing one thing here at the moment,
        // however we may need to do more in the future, so
        // just breaking out each specific part5 of the
        // conversion process to a different method, juuuuust
        // in case
        $newDataObject = $this->convertOldFieldsToNew($dataObject, $newStructure);

        return $newDataObject;
    }

    public function convertOldFieldsToNew($dataObject, $newStructure)
    {
        // If we're dealing with an array with numerical
        // indeces, make a standard array() so the json
        // doesn't get parsed as a hash.
        // we do this by grabbing an array of a) all keys in
        // $newStructure, then b) remove all non-numeric keys.
        // if the count if a == b, generate an array with
        // numerical keys, otherwise make it an object
        $newStrutureArrayKeys = array_keys($newStructure);

        // Count of array keys, and numerical array
        // keys is the same, so make an array()
        if (array_filter($newStrutureArrayKeys, 'is_numeric') == $newStrutureArrayKeys) {
            $newDataObject = array();
        }
        // There is at least one non-numeric key
        // in the array, so make an object using
        // keys as properties
        else {
            $newDataObject = new \stdClass();
        }

        foreach ($newStructure as $field => $value) {
            // $value is an array, could be either
            // associative or numeric array, at this
            // point we don't care
            if (is_array($value)) {
                // run $value through convertOldFieldsToNew
                // recursively until all levels have been
                // assigned the appropriate values from the
                // original $dataObject
                // If $newDataObject is an array (see above),
                // add the return to an array using $field as
                // the key, otherwise, add to an object using
                // $field as the property name
                if (is_array($newDataObject)) {
                    // $newDataObject is an array, so treat
                    // it like one
                    $newDataObject[$field] = $this->convertOldFieldsToNew($dataObject, $value);
                } else {
                    // $newDataObject is an object, so treat
                    // it like one
                    $newDataObject->{$field} = $this->convertOldFieldsToNew($dataObject, $value);
                }
            }
            // $value is not an array, so just add it to 
            // $newDataObject as-is
            else {
                // temporary storage in $newValue,
                // we use this to traverse our array
                $newValue = $dataObject;

                // Get an array of keys we have to
                // recursively parse to get the value
                // we need from the original $dataObject
                $valueMap = explode('->', $value);

                for ($i = 0; $i < count($valueMap); ++$i) {
                    // entry exists in $dataObject, so assign it
                    // to $newValue so we can continue
                    if (isset($newValue->{$valueMap[$i]}) && $newValue->{$valueMap[$i]} !== '') {
                        $newValue = $newValue->{$valueMap[$i]};
                    } else {
                        // value does not exist, so just set null
                        // and break
                        unset($newValue);
                        $newValue = null;
                        break;
                    }
                }

                // only add $newValue to our $newDataObject
                // if it is not a null value
                if (!is_null($newValue)) {
                    // same as above, $newDataObject could
                    // be either an array or object, treat
                    // it accordingly
                    if (is_array($newDataObject)) {
                        $newDataObject[$field] = $newValue;
                    } else {
                        $newDataObject->{$field} = $newValue;
                    }
                }

                // remove temporary storage variables to
                // release memory
                unset($valueMap, $newValue);
            }
        }

        // we're done! return our $newDataObject!
        return $newDataObject;
    }
}
