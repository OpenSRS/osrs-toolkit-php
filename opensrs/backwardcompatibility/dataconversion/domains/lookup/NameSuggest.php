<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\lookup;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class NameSuggest extends DataConversion
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

    // kept for backward compatibility with
    // original class
    public $defaulttld_allnsdomains = array('.com','.net','.org','.info','.biz','.us','.mobi');
    public $defaulttld_alllkdomains = array('.com','.net','.ca','.us','.eu','.de','.co.uk');

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        // run old 'getTlds' method (now called 'getServiceOverride') to get
        // info that should be part of service override entries
        $newDataObject->attributes->service_override = $this->getServiceOverride($dataObject);

        $newDataObject->attributes->services = array('lookup', 'suggestion');
        /* end setting service_override **/

        return $newDataObject;
    }

    /**
     * KEPT FOR BACKWARD COMPATIBILITY ONLY!
     * Get tlds for domain call 
     * Will use (in order of preference)... 
     * 1. selected tlds 
     * 2. supplied default tlds 
     * 3. included default tlds.
     * 
     * UPDATE: NOW ALSO HANDLES data->maximum
     * 
     * @return array tlds 
     */
    protected function getServiceOverride($dataObject)
    {
        $arransSelected = array();
        $arralkSelected = array();
        $arransAll = array();
        $arralkAll = array();
        $arransCall = array();
        $arralkCall = array();

        $selected = array();
        $suppliedDefaults = array();

        // Select non empty one

        // Name Suggestion Choice Check
        if (
            isset($dataObject->data->nsselected) &&
            $dataObject->data->nsselected != ''
        ) {
            $arransSelected = explode(';', $dataObject->data->nsselected);
        }

        // Lookup Choice Check
        if (
            isset($dataObject->data->lkselected) &&
            $dataObject->data->lkselected != ''
        ) {
            $arralkSelected = explode(';', $dataObject->data->lkselected);
        }

        // Get Default Name Suggestion Choices For No Form Submission
        if (
            isset($dataObject->attributes->allnsdomains) &&
            $dataObject->data->allnsdomains != ''
        ) {
            $arransAll = explode(';', $dataObject->attributes->allnsdomains);
        }

        // Get Default Lookup Choices For No Form Submission
        if (
            isset($dataObject->data->alllkdomains) &&
            $dataObject->data->alllkdomains != ''
        ) {
            $arralkAll = explode(';', $dataObject->data->alllkdomains);
        }

        if (count($arransSelected) == 0) {
            if (count($arransAll) == 0) {
                $arransCall = $this->defaulttld_allnsdomains;
            } else {
                $arransCall = $arransAll;
            }
        } else {
            $arransCall = $arransSelected;
        }

        // If Lookup Choices Empty
        if (count($arralkSelected) == 0) {
            if (count($arralkAll) == 0) {
                $arralkCall = $this->defaulttld_alllkdomains;
            } else {
                $arralkCall = $arralkAll;
            }
        } else {
            $arralkCall = $arralkSelected;
        }

        $serviceOverride = array(
            'lookup' => array(
                'tlds' => $arransCall,
                ),
            'suggestion' => array(
                'tlds' => $arralkCall,
                ),
            );

        $serviceOverride = new \stdClass();
        $serviceOverride->lookup = new \stdClass();
        $serviceOverride->suggestion = new \stdClass();

        $serviceOverride->lookup->tlds = $arransCall;
        $serviceOverride->suggestion->tlds = $arralkCall;

        if (isset($dataObject->data->maximum) && $dataObject->data->maximum) {
            $serviceOverride->lookup->maximum = $dataObject->data->maximum;
            $serviceOverride->suggestion->maximum = $dataObject->data->maximum;
        }

        return $serviceOverride;
    }
}
