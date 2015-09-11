<?php

namespace OpenSRS\backwardcompatibility\dataconversion;

use OpenSRS\Base;
use OpenSRS\Exception;

class DataConversion extends Base {

	public function convertDataObject( $dataObject, $newStructure ) {
		$newDataObject = $this->convertOldFieldsToNew( $dataObject, $newStructure );

		return $newDataObject;
	}

	public function convertOldFieldsToNew( $dataObject, $newStructure ){
		$newDataObject = new \stdClass;

		foreach( $newStructure as $field => $value ) {
			if(is_array( $value )) {
				$newDataObject->$field = $this->convertOldFieldsToNew( $dataObject, $value );
			}
			else {
				$newValue = $dataObject;
				$valueMap = explode('->', $value);

				for( $i = 0; $i < count($valueMap); $i++ ) {
					if(isset( $newValue->{$valueMap[$i]} ) && $newValue->{$valueMap[$i]} ){
						$newValue = $newValue->{$valueMap[$i]};
					}
					else{
						unset($newValue);
						$newValue = null;
						break;
					}
				}

				if( !is_null($newValue) ){
					$newDataObject->{$field} = $newValue;
				}

				unset( $valueMap, $newValue );
			}
		}

		return $newDataObject;
	}
}