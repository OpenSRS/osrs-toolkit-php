<?php

namespace OpenSRS;

class RequestFactory
{
    public static function build($func, $type, $dataObject)
    {
        switch ($func) {
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

            case 'lookupGetOrdersByDomain':
                return new \OpenSRS\domains\lookup\GetOrdersByDomain($type, $dataObject);
                break;

            case 'lookupGetPrice':
                return new \OpenSRS\domains\lookup\GetPrice($type, $dataObject);
                break;

            case 'lookupNameSuggest':
                return new \OpenSRS\domains\lookup\NameSuggest($type, $dataObject);
                break;

            case 'suggestDomain':
                return new \OpenSRS\domains\lookup\SuggestDomain($type, $dataObject);
                break;

            case 'lookupBelongsToRsp':
                return new \OpenSRS\domains\lookup\BelongsToRsp($type, $dataObject);
                break;

            case 'allinoneDomain':
                return new \OpenSRS\domains\lookup\AllInOneDomain($type, $dataObject);
                break;

            case 'lookupGetCaBlockerList':
                return new \OpenSRS\domains\lookup\GetCaBlockerList($type, $dataObject);
                break;

            case 'provSWregister':
                return new \OpenSRS\domains\provisioning\SWRegister($type, $dataObject);
                break;

            case 'fastDomainLookup':
                return new \OpenSRS\fastlookup\FastDomainLookup($type, $dataObject); 
                break;

            case 'trustCancelOrder':
                return new \OpenSRS\trust\CancelOrder($type, $dataObject); 
                break;

            case 'trustCreateToken':
                return new \OpenSRS\trust\CreateToken($type, $dataObject); 
                break;

            case 'trustGetOrderInfo':
                return new \OpenSRS\trust\GetOrderInfo($type, $dataObject); 
                break;

            case 'trustProductInfo':
                return new \OpenSRS\trust\ProductInfo($type, $dataObject); 
                break;

            default:
                throw new Exception("OSRS Error - $func is unsupported.");
        }
    }
}
