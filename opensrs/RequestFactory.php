<?php

namespace OpenSRS;

class RequestFactory
{
    public static function build( $func, $type, $dataObject )
    {
        switch( $func ) {
            case 'premiumDomain':
                return new \OpenSRS\domains\lookup\PremiumDomain( $type, $dataObject );
                break;

            case 'lookupDomain':
                return new \OpenSRS\domains\lookup\LookupDomain( $type, $dataObject );
                break;

            case 'lookupGetDomain':
                return new \OpenSRS\domains\lookup\GetDomain( $type, $dataObject );
                break;

            case 'lookupGetBalance':
                return new \OpenSRS\domains\lookup\GetBalance( $type, $dataObject );
                break;

            case 'lookupGetDeletedDomains':
                return new \OpenSRS\domains\lookup\GetDeletedDomains( $type, $dataObject );
                break;

            case 'lookupGetDomansByExpiry':
                return new \OpenSRS\domains\lookup\GetDomansByExpiry( $type, $dataObject );
                break;

            case 'lookupGetDomainsContacts':
                return new \OpenSRS\domains\lookup\GetDomainsContacts( $type, $dataObject );
                break;

            case 'lookupGetNotes':
                return new \OpenSRS\domains\lookup\GetNotes( $type, $dataObject );
                break;

            case 'lookupGetOrderInfo':
                return new \OpenSRS\domains\lookup\GetOrderInfo( $type, $dataObject );
                break;

            case 'lookupGetOrdersByDomain':
                return new \OpenSRS\domains\lookup\GetOrdersByDomain( $type, $dataObject );
                break;

            case 'lookupGetPrice':
                return new \OpenSRS\domains\lookup\GetPrice( $type, $dataObject );
                break;

            case 'lookupNameSuggest':
                return new \OpenSRS\domains\lookup\NameSuggest( $type, $dataObject );
                break;

            case 'suggestDomain':
                return new \OpenSRS\domains\lookup\SuggestDomain( $type, $dataObject );
                break;

            case 'lookupBelongsToRsp':
                return new \OpenSRS\domains\lookup\BelongsToRsp( $type, $dataObject );
                break;

            case 'allinoneDomain':
                return new \OpenSRS\domains\lookup\AllInOneDomain( $type, $dataObject );
                break;

            case 'lookupGetCaBlockerList':
                return new \OpenSRS\domains\lookup\GetCaBlockerList( $type, $dataObject );
                break;

            case 'provSWregister':
                return new \OpenSRS\domains\provisioning\SWRegister( $type, $dataObject );
                break;

            case 'fastDomainLookup':
                return new \OpenSRS\fastlookup\FastDomainLookup( $type, $dataObject );
                break;

            case 'authChangeOwnership':
                return new \OpenSRS\domains\authentication\ChangeOwnership( $type, $dataObject );
                break;

            case 'authChangePassword':
                return new \OpenSRS\domains\authentication\ChangePassword( $type, $dataObject );
                break;

            case 'authCheckVersion':
                return new \OpenSRS\domains\authentication\CheckVersion( $type, $dataObject );
                break;

            case 'authSendAuthcode':
                return new \OpenSRS\domains\authentication\SendAuthcode( $type, $dataObject );
                break;

            case 'authSendPassword':
                return new \OpenSRS\domains\authentication\SendPassword( $type, $dataObject );
                break;

            case 'bulkChange':
                return new \OpenSRS\domains\bulkchange\BulkChange( $type, $dataObject );
                break;

            case 'bulkSubmit':
                return new \OpenSRS\domains\bulkchange\BulkSubmit( $type, $dataObject );
                break;

            case 'bulkTransfer':
                return new \OpenSRS\domains\bulkchange\BulkTransfer( $type, $dataObject );
                break;

            case 'cookieDelete':
                return new \OpenSRS\domains\bulkchange\CookieDelete( $type, $dataObject );
                break;

            case 'CookieQuit':
                return new \OpenSRS\domains\bulkchange\CookieQuit( $type, $dataObject );
                break;

            case 'cookieSet':
                return new \OpenSRS\domains\bulkchange\CookieSet( $type, $dataObject );
                break;

            case 'cookieUpdate':
                return new \OpenSRS\domains\bulkchange\CookieUpdate( $type, $dataObject );
                break;

            case 'dnsCreate':
                return new \OpenSRS\domains\bulkchange\DnsCreate( $type, $dataObject );
                break;

            case 'dnsDelete':
                return new \OpenSRS\domains\bulkchange\DnsDelete( $type, $dataObject );
                break;

            case 'dnsForce':
                return new \OpenSRS\domains\bulkchange\DnsForce( $type, $dataObject );
                break;

            case 'dnsGet':
                return new \OpenSRS\domains\bulkchange\DnsGet( $type, $dataObject );
                break;

            case 'dnsReset':
                return new \OpenSRS\domains\bulkchange\DnsReset( $type, $dataObject );
                break;

            case 'dnsSet':
                return new \OpenSRS\domains\bulkchange\DnsSet( $type, $dataObject );
                break;

            case 'trustCancelOrder':
                return new \OpenSRS\trust\CancelOrder( $type, $dataObject );
                break;

            case 'trustCreateToken':
                return new \OpenSRS\trust\CreateToken( $type, $dataObject );
                break;

            case 'trustGetOrderInfo':
                return new \OpenSRS\trust\GetOrderInfo( $type, $dataObject );
                break;

            case 'trustProductInfo':
                return new \OpenSRS\trust\ProductInfo( $type, $dataObject );
                break;

            case 'trustParseCSR':
                return new \OpenSRS\trust\ParseCSR( $type, $dataObject );
                break;

            case 'trustProcessPending':
                return new \OpenSRS\trust\ProcessPending( $type, $dataObject );
                break;

            case 'trustQueryApproverList':
                return new \OpenSRS\trust\QueryApproverList( $type, $dataObject );
                break;

            case 'trustRequestOnDemandScan':
                return new \OpenSRS\trust\RequestOnDemandScan( $type, $dataObject );
                break;

            case 'trustResendApproverEmail':
                return new \OpenSRS\trust\ResendApproverEmail( $type, $dataObject );
                break;

            case 'trustResendCertEmail':
                return new \OpenSRS\trust\ResendCertEmail( $type, $dataObject );
                break;

            case 'trustUpdateOrder':
                return new \OpenSRS\trust\UpdateOrder( $type, $dataObject );
                break;

            case 'trustUpdateProduct':
                return new \OpenSRS\trust\UpdateProduct( $type, $dataObject );
                break;

            default:
                throw new Exception( "OSRS Error - $func is unsupported." );
                break;
        }
    }
}
