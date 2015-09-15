<?php

namespace OpenSRS;

/**
 * DataObjectTrait
 *
 * OpenSRS request DataObjectTrait shares common dataObject functionality
 *
 */
trait DataObjectTrait
{
    protected $dataObject;
    protected $dataFormat;

    /**
     * Set the data object and the format 
     * 
     * @param string $format format 
     * @param sdtClass $dataObject dataObject 
     * 
     * @return void
     */
    public function setDataObject($format, $dataObject)
    {
        $this->dataObject = $dataObject;
        $this->dataFormat = $format;
    }

    /**
     * Does the dataObject have a domain set?
     * 
     * @return bool 
     */
    public function hasDomain()
    {
        return isset($this->dataObject->data->domain);
    }

    /**
     * Get the domain from the dataObject
     * 
     * @return void
     */
    public function getDomain()
    {
        return $this->dataObject->data->domain; 
    }

    /**
     * Does the dataObject have selected tlds set?
     * 
     * @return void
     */
    public function hasSelected()
    {
        return isset($this->dataObject->data->selected);
    }

    /**
     * Get dataObject selected tlds 
     * 
     * @return array selected tlds 
     */
    public function getSelected()
    {
        return explode(';', $this->dataObject->data->selected);
    }

    /**
     * Does the dataObject have allDomains set?
     * 
     * 
     * @return void
     */
    public function hasAllDomains()
    {
        return isset($this->dataObject->data->alldomains); 
    }

    /**
     * Get dataObject alldomains tlds
     * 
     * @return void
     */
    public function getAllDomains()
    {
        return explode(';', $this->dataObject->data->alldomains);
    }
}
