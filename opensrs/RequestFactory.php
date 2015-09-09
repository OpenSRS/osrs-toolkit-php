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

            case 'provActivate':
                return new \OpenSRS\domains\provisioning\ProvisioningActivate( $type, $dataObject );
                break;

            case 'provCancelActivate':
                return new \OpenSRS\domains\provisioning\ProvisioningCancelActivate( $type, $dataObject );
                break;

            case 'provCancelPending':
                return new \OpenSRS\domains\provisioning\ProvisioningCancelPending( $type, $dataObject );
                break;

            case 'provModify':
                return new \OpenSRS\domains\provisioning\ProvisioningModify( $type, $dataObject );
                break;

            case 'provProcessPending':
                return new \OpenSRS\domains\provisioning\ProvisioningProcessPending( $type, $dataObject );
                break;

            case 'provQueryQueuedRequest':
                return new \OpenSRS\domains\provisioning\ProvisioningQueryQueuedRequest( $type, $dataObject );
                break;

            case 'provRenew':
                return new \OpenSRS\domains\provisioning\ProvisioningRenew( $type, $dataObject );
                break;

            case 'provRevoke':
                return new \OpenSRS\domains\provisioning\ProvisioningRevoke( $type, $dataObject );
                break;

            case 'provSendCIRAapproval':
                return new \OpenSRS\domains\provisioning\ProvisioningSendCIRAApproval( $type, $dataObject );
                break;

            case 'provUpdateAllInfo':
                return new \OpenSRS\domains\provisioning\ProvisioningUpdateAllInfo( $type, $dataObject );
                break;

            case 'provUpdateContacts':
                return new \OpenSRS\domains\provisioning\ProvisioningUpdateContacts( $type, $dataObject );
                break;

            case 'subresCreate':
                return new \OpenSRS\domains\provisioning\SubresellerCreate( $type, $dataObject );
                break;

            case 'subresGet':
                return new \OpenSRS\domains\provisioning\SubresellerGet( $type, $dataObject );
                break;

            case 'subresModify':
                return new \OpenSRS\domains\provisioning\SubresellerModify( $type, $dataObject );
                break;

            case 'subresPay':
                return new \OpenSRS\domains\provisioning\SubresellerPay( $type, $dataObject );
                break;

            case 'subuserAdd':
                return new \OpenSRS\domains\provisioning\SubuserAdd( $type, $dataObject );
                break;

            case 'subuserDelete':
                return new \OpenSRS\domains\provisioning\SubuserDelete( $type, $dataObject );
                break;

            case 'subuserGet':
                return new \OpenSRS\domains\provisioning\SubuserGet( $type, $dataObject );
                break;

            case 'subuserGetInfo':
                return new \OpenSRS\domains\provisioning\SubuserGetInfo( $type, $dataObject );
                break;

            case 'subuserModify':
                return new \OpenSRS\domains\provisioning\SubuserModify( $type, $dataObject );
                break;

            case 'transCancel':
                return new \OpenSRS\domains\transfer\TransferCancel( $type, $dataObject );
                break;

            case 'transCheck':
                return new \OpenSRS\domains\transfer\TransferCheck( $type, $dataObject );
                break;

            case 'transGetAway':
                return new \OpenSRS\domains\transfer\TransferGetAway( $type, $dataObject );
                break;

            case 'transGetIn':
                return new \OpenSRS\domains\transfer\TransferGetIn( $type, $dataObject );
                break;

            case 'transProcess':
                return new \OpenSRS\domains\transfer\TransferProcess( $type, $dataObject );
                break;

            case 'transRsp2Rsp':
                return new \OpenSRS\domains\transfer\TransferRsp2Rsp( $type, $dataObject );
                break;

            case 'transSendPass':
                return new \OpenSRS\domains\transfer\TransferSendPassword( $type, $dataObject );
                break;

            case 'transTradeDomain':
                return new \OpenSRS\domains\transfer\TransferTradeDomain( $type, $dataObject );
                break;

            case 'fastDomainLookup':
                return new \OpenSRS\fastlookup\FastDomainLookup( $type, $dataObject );
                break;

            case 'authChangeOwnership':
                return new \OpenSRS\domains\authentication\AuthenticationChangeOwnership( $type, $dataObject );
                break;

            case 'authChangePassword':
                return new \OpenSRS\domains\authentication\AuthenticationChangePassword( $type, $dataObject );
                break;

            case 'authCheckVersion':
                return new \OpenSRS\domains\authentication\AuthenticationCheckVersion( $type, $dataObject );
                break;

            case 'authSendAuthcode':
                return new \OpenSRS\domains\authentication\AuthenticationSendAuthCode( $type, $dataObject );
                break;

            case 'authSendPassword':
                return new \OpenSRS\domains\authentication\AuthenticationSendPassword( $type, $dataObject );
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
                return new \OpenSRS\domains\cookie\CookieDelete( $type, $dataObject );
                break;

            case 'CookieQuit':
                return new \OpenSRS\domains\cookie\CookieQuit( $type, $dataObject );
                break;

            case 'cookieSet':
                return new \OpenSRS\domains\cookie\CookieSet( $type, $dataObject );
                break;

            case 'cookieUpdate':
                return new \OpenSRS\domains\cookie\CookieUpdate( $type, $dataObject );
                break;

            case 'dnsCreate':
                return new \OpenSRS\domains\dnszone\DnsCreate( $type, $dataObject );
                break;

            case 'dnsDelete':
                return new \OpenSRS\domains\dnszone\DnsDelete( $type, $dataObject );
                break;

            case 'dnsForce':
                return new \OpenSRS\domains\dnszone\DnsForce( $type, $dataObject );
                break;

            case 'dnsGet':
                return new \OpenSRS\domains\dnszone\DnsGet( $type, $dataObject );
                break;

            case 'dnsReset':
                return new \OpenSRS\domains\dnszone\DnsReset( $type, $dataObject );
                break;

            case 'dnsSet':
                return new \OpenSRS\domains\dnszone\DnsSet( $type, $dataObject );
                break;

            case 'fwdCreate':
                return new \OpenSRS\domains\forwarding\ForwardingCreate( $type, $dataObject );
                break;

            case 'fwdDelete':
                return new \OpenSRS\domains\forwarding\ForwardingDelete( $type, $dataObject );
                break;

            case 'fwdGet':
                return new \OpenSRS\domains\forwarding\ForwardingGet( $type, $dataObject );
                break;

            case 'fwdSet':
                return new \OpenSRS\domains\forwarding\ForwardingSet( $type, $dataObject );
                break;

            case 'nsAdvancedUpdt':
                return new \OpenSRS\domains\nameserver\NameserverAdvancedUpdate( $type, $dataObject );
                break;

            case 'nsCreate':
                return new \OpenSRS\domains\nameserver\NameserverCreate( $type, $dataObject );
                break;

            case 'nsDelete':
                return new \OpenSRS\domains\nameserver\NameserverDelete( $type, $dataObject );
                break;

            case 'nsGet':
                return new \OpenSRS\domains\nameserver\NameserverGet( $type, $dataObject );
                break;

            case 'nsModify':
                return new \OpenSRS\domains\nameserver\NameserverModify( $type, $dataObject );
                break;

            case 'nsRegistryAdd':
                return new \OpenSRS\domains\nameserver\NameserverRegistryAdd( $type, $dataObject );
                break;

            case 'nsRegistryCheck':
                return new \OpenSRS\domains\nameserver\NameserverRegistryCheck( $type, $dataObject );
                break;

            case 'persDelete':
                return new \OpenSRS\domains\personalnames\PersonalNamesDelete( $type, $dataObject );
                break;

            case 'persNameSuggest':
                return new \OpenSRS\domains\personalnames\PersonalNamesNameSuggest( $type, $dataObject );
                break;

            case 'persQuery':
                return new \OpenSRS\domains\personalnames\PersonalNamesQuery( $type, $dataObject );
                break;

            case 'persSUregister':
                return new \OpenSRS\domains\personalnames\PersonalNamesSURegister( $type, $dataObject );
                break;

            case 'persUpdate':
                return new \OpenSRS\domains\personalnames\PersonalNamesUpdate( $type, $dataObject );
                break;

            case 'pubCreate':
                return new \OpenSRS\publishing\Create( $type, $dataObject );
                break;

            case 'pubDelete':
                return new \OpenSRS\publishing\Delete( $type, $dataObject );
                break;

            case 'pubDisable':
                return new \OpenSRS\publishing\Disable( $type, $dataObject );
                break;

            case 'pubEnable':
                return new \OpenSRS\publishing\Enable( $type, $dataObject );
                break;

            case 'pubGenerateRedirectionCode':
                return new \OpenSRS\publishing\GenerateRedirectionCode( $type, $dataObject );
                break;

            case 'pubGetControlPanelUrl':
                return new \OpenSRS\publishing\GetControlPanelUrl( $type, $dataObject );
                break;

            case 'pubGetServiceInfo':
                return new \OpenSRS\publishing\GetServiceInfo( $type, $dataObject );
                break;

            case 'pubLetExpire':
                return new \OpenSRS\publishing\LetExpire( $type, $dataObject );
                break;

            case 'pubUpdate':
                return new \OpenSRS\publishing\Update( $type, $dataObject );
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

            case 'mailAuthentication':
                return new \OpenSRS\mail\Authentication( $type, $dataObject );
                break;

            case 'mailChangeDomain':
                return new \OpenSRS\mail\ChangeDomain( $type, $dataObject );
                break;

            case 'mailCreateDomainAlias':
                return new \OpenSRS\mail\CreateDomainAlias( $type, $dataObject );
                break;

            case 'mailCreateDomain':
                return new \OpenSRS\mail\CreateDomain( $type, $dataObject );
                break;
                
            case 'mailCreateDomainWelcomeEmail':
                return new \OpenSRS\mail\CreateDomainWelcomeEmail( $type, $dataObject );
                break;

            case 'mailCreateMailboxForwardOnly':
                return new \OpenSRS\mail\CreateMailboxForwardOnly( $type, $dataObject );
                break;

            case 'mailCreateMailbox':
                return new \OpenSRS\mail\CreateMailbox( $type, $dataObject );
                break;

            case 'mailDeleteDomainAlias':
                return new \OpenSRS\mail\DeleteDomainAlias( $type, $dataObject );
                break;

            case 'mailDeleteDomain':
                return new \OpenSRS\mail\DeleteDomain( $type, $dataObject );
                break;

            case 'mailDeleteDomainWelcomeEmail':
                return new \OpenSRS\mail\DeleteDomainWelcomeEmail( $type, $dataObject );
                break;

            case 'mailDeleteMailbox':
                return new \OpenSRS\mail\DeleteMailbox( $type, $dataObject );
                break;

            case 'mailGetCompanyDomains':
                return new \OpenSRS\mail\GetCompanyDomains( $type, $dataObject );
                break;

            case 'mailGetDomainAllowList':
                return new \OpenSRS\mail\GetDomainAllowList( $type, $dataObject );
                break;

            case 'mailGetDomainBlockList':
                return new \OpenSRS\mail\GetDomainBlockList( $type, $dataObject );
                break;

            case 'mailGetDomainMailboxes':
                return new \OpenSRS\mail\GetDomainMailboxes( $type, $dataObject );
                break;

            case 'mailGetDomainMailboxLimits':
                return new \OpenSRS\mail\GetDomainMailboxLimits( $type, $dataObject );
                break;


            default:
                throw new Exception( "OSRS Error - $func is unsupported." );
                break;
        }
    }
}
