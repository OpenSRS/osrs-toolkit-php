<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\lookup;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class SuggestDomain extends DataConversion
{
    // New structure for API calls handled by
    // the toolkit.
    //
    // index: field name
    // value: location of data to map to this
    //		  field from the original structure
    //
    // example 1:
    //    "cookie" => 'data->cookie'
    //	this will map ->data->cookie in the
    //	original object to ->cookie in the
    //  new format
    //
    // example 2:
    //	  ['attributes']['domain'] = 'data->domain'
    //  this will map ->data->domain in the original
    //  to ->attributes->domain in the new format
    protected $newStructure = array(
        'attributes' => array(
            // setting this one by hand below
            // 'services' => 'data->domain',
            'searchstring' => 'data->domain',

            // setting service_override and its
            // contents by hand below, better
            // performance to just do it since we
            // know where it's coming from than
            // have a ton of conditionals,
            // if(is_object(... etc etc .... ))
            // 'service_override' => array(

            // 	'lookup' =>	array(
            // 		'maximum' => 'data->maximum',
            // 		),

            // 	'premium' => array(
            // 		'maximum' => 'data->maximum',
            // 		),

            // 	'suggestion' => array(
            // 		'maximum' => 'data->maximum',
            // 		),

            // 	),
            // ),
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        $tlds = array();

        if (isset($dataObject->data->selected) && $dataObject->data->selected) {
            $tlds = explode(';', $dataObject->data->selected);
        }
        if (
            empty($tlds) &&
            isset($dataObject->data->defaulttld) &&
            $dataObject->data->defaulttld
        ) {
            $tlds = explode(';', $dataObject->data->defaulttld);
        }

        if (empty($tlds)) {
            $tlds = $this->defaultTlds;
        }

        /*
         * setting service_override
         */
        $newDataObject->attributes->service_override = new \stdClass();
        $service_override = new \stdCLass();
        $service_override->tlds = $tlds;

        if (isset($dataObject->data->maximum) && $dataObject->data->maximum) {
            $service_override->maximum = $dataObject->data->maximum;
        }

        $newDataObject->attributes->service_override->suggestion = $service_override;

        $newDataObject->attributes->services = array('suggestion');
        /* end setting service_override **/

        return $newDataObject;
    }
}
