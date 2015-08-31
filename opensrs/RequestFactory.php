<?php

namespace OpenSRS;

class RequestFactory
{
    public static function build($func, $type, $dataObject)
    {
        switch($func) {
            case 'premiumDomain':
                return new \OpenSRS\domains\lookup\PremiumDomain($type, $dataObject); 
                break;

            case 'lookupDomain':
                return new \OpenSRS\domains\lookup\LookupDomain($type, $dataObject);
                break;

            case 'lookupGetDomain':
                return new \OpenSRS\domains\lookup\GetDomain($type, $dataObject);
                break;

            case 'lookupGetBalance':
                return new \OpenSRS\domains\lookup\GetBalance($type, $dataObject);
                break;

            case 'lookupGetDeletedDomains':
                return new \OpenSRS\domains\lookup\GetDeletedDomains($type, $dataObject);
                break;

            case 'lookupGetDomansByExpiry':
                return new \OpenSRS\domains\lookup\GetDomansByExpiry($type, $dataObject);
                break;

            case 'lookupGetDomainsContacts':
                return new \OpenSRS\domains\lookup\GetDomainsContacts($type, $dataObject);
                break;

            case 'lookupGetNotes':
                return new \OpenSRS\domains\lookup\GetNotes($type, $dataObject);
                break;

            case 'lookupGetOrderInfo':
                return new \OpenSRS\domains\lookup\GetOrderInfo($type, $dataObject);
                break;

            default:
                throw new Exception("OSRS Error - $func is unsupported.");
        } 
    }
}
