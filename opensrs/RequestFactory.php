<?php

namespace OpenSRS;

class RequestFactory
{
    public static function build( $func, $type, $dataObject )
    {
        switch( strtolower($func) ) {
            case 'premiumdomain':
                return new \OpenSRS\domains\lookup\PremiumDomain( $type, $dataObject );
                break;

            case 'lookupdomain':
                return new \OpenSRS\domains\lookup\LookupDomain( $type, $dataObject );
                break;

            case 'lookupgetdomain':
                return new \OpenSRS\domains\lookup\GetDomain( $type, $dataObject );
                break;

            case 'lookupgetbalance':
                return new \OpenSRS\domains\lookup\GetBalance( $type, $dataObject );
                break;

            case 'lookupgetdeleteddomains':
                return new \OpenSRS\domains\lookup\GetDeletedDomains( $type, $dataObject );
                break;

            case 'lookupgetdomansbyexpiry':
                return new \OpenSRS\domains\lookup\GetDomansByExpiry( $type, $dataObject );
                break;

            case 'lookupgetdomainscontacts':
                return new \OpenSRS\domains\lookup\GetDomainsContacts( $type, $dataObject );
                break;

            case 'lookupgetnotes':
                return new \OpenSRS\domains\lookup\GetNotes( $type, $dataObject );
                break;

            case 'lookupgetorderinfo':
                return new \OpenSRS\domains\lookup\GetOrderInfo( $type, $dataObject );
                break;

            case 'lookupgetordersbydomain':
                return new \OpenSRS\domains\lookup\GetOrdersByDomain( $type, $dataObject );
                break;

            case 'lookupgetprice':
                return new \OpenSRS\domains\lookup\GetPrice( $type, $dataObject );
                break;

            case 'lookupnamesuggest':
                return new \OpenSRS\domains\lookup\NameSuggest( $type, $dataObject );
                break;

            case 'suggestdomain':
                return new \OpenSRS\domains\lookup\SuggestDomain( $type, $dataObject );
                break;

            case 'lookupbelongstorsp':
                return new \OpenSRS\domains\lookup\BelongsToRsp( $type, $dataObject );
                break;

            case 'allinonedomain':
                return new \OpenSRS\domains\lookup\AllInOneDomain( $type, $dataObject );
                break;

            case 'lookupgetcablockerlist':
                return new \OpenSRS\domains\lookup\GetCaBlockerList( $type, $dataObject );
                break;

            case 'provswregister':
                return new \OpenSRS\domains\provisioning\SWRegister( $type, $dataObject );
                break;

            case 'provactivate':
                return new \OpenSRS\domains\provisioning\ProvisioningActivate( $type, $dataObject );
                break;

            case 'provcancelactivate':
                return new \OpenSRS\domains\provisioning\ProvisioningCancelActivate( $type, $dataObject );
                break;

            case 'provcancelpending':
                return new \OpenSRS\domains\provisioning\ProvisioningCancelPending( $type, $dataObject );
                break;

            case 'provmodify':
                return new \OpenSRS\domains\provisioning\ProvisioningModify( $type, $dataObject );
                break;

            case 'provprocesspending':
                return new \OpenSRS\domains\provisioning\ProvisioningProcessPending( $type, $dataObject );
                break;

            case 'provqueryqueuedrequest':
                return new \OpenSRS\domains\provisioning\ProvisioningQueryQueuedRequest( $type, $dataObject );
                break;

            case 'provrenew':
                return new \OpenSRS\domains\provisioning\ProvisioningRenew( $type, $dataObject );
                break;

            case 'provrevoke':
                return new \OpenSRS\domains\provisioning\ProvisioningRevoke( $type, $dataObject );
                break;

            case 'provsendciraapproval':
                return new \OpenSRS\domains\provisioning\ProvisioningSendCIRAApproval( $type, $dataObject );
                break;

            case 'provupdateallinfo':
                return new \OpenSRS\domains\provisioning\ProvisioningUpdateAllInfo( $type, $dataObject );
                break;

            case 'provupdatecontacts':
                return new \OpenSRS\domains\provisioning\ProvisioningUpdateContacts( $type, $dataObject );
                break;

            case 'subrescreate':
                return new \OpenSRS\domains\subreseller\SubresellerCreate( $type, $dataObject );
                break;

            case 'subresget':
                return new \OpenSRS\domains\subreseller\SubresellerGet( $type, $dataObject );
                break;

            case 'subresmodify':
                return new \OpenSRS\domains\subreseller\SubresellerModify( $type, $dataObject );
                break;

            case 'subrespay':
                return new \OpenSRS\domains\subreseller\SubresellerPay( $type, $dataObject );
                break;

            case 'subuseradd':
                return new \OpenSRS\domains\subuser\SubuserAdd( $type, $dataObject );
                break;

            case 'subuserdelete':
                return new \OpenSRS\domains\subuser\SubuserDelete( $type, $dataObject );
                break;

            case 'subuserget':
                return new \OpenSRS\domains\subuser\SubuserGet( $type, $dataObject );
                break;

            case 'subusergetinfo':
                return new \OpenSRS\domains\subuser\SubuserGetInfo( $type, $dataObject );
                break;

            case 'subusermodify':
                return new \OpenSRS\domains\subuser\SubuserModify( $type, $dataObject );
                break;

            case 'transcancel':
                return new \OpenSRS\domains\transfer\TransferCancel( $type, $dataObject );
                break;

            case 'transcheck':
                return new \OpenSRS\domains\transfer\TransferCheck( $type, $dataObject );
                break;

            case 'transgetaway':
                return new \OpenSRS\domains\transfer\TransferGetAway( $type, $dataObject );
                break;

            case 'transgetin':
                return new \OpenSRS\domains\transfer\TransferGetIn( $type, $dataObject );
                break;

            case 'transprocess':
                return new \OpenSRS\domains\transfer\TransferProcess( $type, $dataObject );
                break;

            case 'transRsp2Rsp':
                return new \OpenSRS\domains\transfer\TransferRsp2Rsp( $type, $dataObject );
                break;

            case 'transsendpass':
                return new \OpenSRS\domains\transfer\TransferSendPassword( $type, $dataObject );
                break;

            case 'transtradedomain':
                return new \OpenSRS\domains\transfer\TransferTradeDomain( $type, $dataObject );
                break;

            case 'fastdomainlookup':
                return new \OpenSRS\fastlookup\FastDomainLookup( $type, $dataObject );
                break;

            case 'authchangeownership':
                return new \OpenSRS\domains\authentication\AuthenticationChangeOwnership( $type, $dataObject );
                break;

            case 'authchangepassword':
                return new \OpenSRS\domains\authentication\AuthenticationChangePassword( $type, $dataObject );
                break;

            case 'authcheckversion':
                return new \OpenSRS\domains\authentication\AuthenticationCheckVersion( $type, $dataObject );
                break;

            case 'authsendauthcode':
                return new \OpenSRS\domains\authentication\AuthenticationSendAuthCode( $type, $dataObject );
                break;

            case 'authsendpassword':
                return new \OpenSRS\domains\authentication\AuthenticationSendPassword( $type, $dataObject );
                break;

            case 'bulkchange':
                return new \OpenSRS\domains\bulkchange\BulkChange( $type, $dataObject );
                break;

            case 'bulksubmit':
                return new \OpenSRS\domains\bulkchange\BulkSubmit( $type, $dataObject );
                break;

            case 'bulktransfer':
                return new \OpenSRS\domains\bulkchange\BulkTransfer( $type, $dataObject );
                break;

            case 'cookiedelete':
                return new \OpenSRS\domains\cookie\CookieDelete( $type, $dataObject );
                break;

            case 'cookiequit':
                return new \OpenSRS\domains\cookie\CookieQuit( $type, $dataObject );
                break;

            case 'cookieset':
                return new \OpenSRS\domains\cookie\CookieSet( $type, $dataObject );
                break;

            case 'cookieupdate':
                return new \OpenSRS\domains\cookie\CookieUpdate( $type, $dataObject );
                break;

            case 'dnscreate':
                return new \OpenSRS\domains\dnszone\DnsCreate( $type, $dataObject );
                break;

            case 'dnsdelete':
                return new \OpenSRS\domains\dnszone\DnsDelete( $type, $dataObject );
                break;

            case 'dnsforce':
                return new \OpenSRS\domains\dnszone\DnsForce( $type, $dataObject );
                break;

            case 'dnsget':
                return new \OpenSRS\domains\dnszone\DnsGet( $type, $dataObject );
                break;

            case 'dnsreset':
                return new \OpenSRS\domains\dnszone\DnsReset( $type, $dataObject );
                break;

            case 'dnsset':
                return new \OpenSRS\domains\dnszone\DnsSet( $type, $dataObject );
                break;

            case 'fwdcreate':
                return new \OpenSRS\domains\forwarding\ForwardingCreate( $type, $dataObject );
                break;

            case 'fwddelete':
                return new \OpenSRS\domains\forwarding\ForwardingDelete( $type, $dataObject );
                break;

            case 'fwdget':
                return new \OpenSRS\domains\forwarding\ForwardingGet( $type, $dataObject );
                break;

            case 'fwdset':
                return new \OpenSRS\domains\forwarding\ForwardingSet( $type, $dataObject );
                break;

            case 'nsadvancedupdt':
                return new \OpenSRS\domains\nameserver\NameserverAdvancedUpdate( $type, $dataObject );
                break;

            case 'nscreate':
                return new \OpenSRS\domains\nameserver\NameserverCreate( $type, $dataObject );
                break;

            case 'nsdelete':
                return new \OpenSRS\domains\nameserver\NameserverDelete( $type, $dataObject );
                break;

            case 'nsget':
                return new \OpenSRS\domains\nameserver\NameserverGet( $type, $dataObject );
                break;

            case 'nsmodify':
                return new \OpenSRS\domains\nameserver\NameserverModify( $type, $dataObject );
                break;

            case 'nsregistryadd':
                return new \OpenSRS\domains\nameserver\NameserverRegistryAdd( $type, $dataObject );
                break;

            case 'nsregistrycheck':
                return new \OpenSRS\domains\nameserver\NameserverRegistryCheck( $type, $dataObject );
                break;

            case 'persdelete':
                return new \OpenSRS\domains\personalnames\PersonalNamesDelete( $type, $dataObject );
                break;

            case 'persnamesuggest':
                return new \OpenSRS\domains\personalnames\PersonalNamesNameSuggest( $type, $dataObject );
                break;

            case 'persquery':
                return new \OpenSRS\domains\personalnames\PersonalNamesQuery( $type, $dataObject );
                break;

            case 'perssuregister':
                return new \OpenSRS\domains\personalnames\PersonalNamesSURegister( $type, $dataObject );
                break;

            case 'persupdate':
                return new \OpenSRS\domains\personalnames\PersonalNamesUpdate( $type, $dataObject );
                break;

            case 'pubcreate':
                return new \OpenSRS\publishing\Create( $type, $dataObject );
                break;

            case 'pubdelete':
                return new \OpenSRS\publishing\Delete( $type, $dataObject );
                break;

            case 'pubdisable':
                return new \OpenSRS\publishing\Disable( $type, $dataObject );
                break;

            case 'pubenable':
                return new \OpenSRS\publishing\Enable( $type, $dataObject );
                break;

            case 'pubgenerateredirectioncode':
                return new \OpenSRS\publishing\GenerateRedirectionCode( $type, $dataObject );
                break;

            case 'pubgetcontrolpanelurl':
                return new \OpenSRS\publishing\GetControlPanelUrl( $type, $dataObject );
                break;

            case 'pubgetserviceinfo':
                return new \OpenSRS\publishing\GetServiceInfo( $type, $dataObject );
                break;

            case 'publetexpire':
                return new \OpenSRS\publishing\LetExpire( $type, $dataObject );
                break;

            case 'pubupdate':
                return new \OpenSRS\publishing\Update( $type, $dataObject );
                break;

            case 'trustcancelorder':
                return new \OpenSRS\trust\CancelOrder( $type, $dataObject );
                break;

            case 'trustcreatetoken':
                return new \OpenSRS\trust\CreateToken( $type, $dataObject );
                break;

            case 'trustgetorderinfo':
                return new \OpenSRS\trust\GetOrderInfo( $type, $dataObject );
                break;

            case 'trustproductinfo':
                return new \OpenSRS\trust\ProductInfo( $type, $dataObject );
                break;

            case 'trustparsecsr':
                return new \OpenSRS\trust\ParseCSR( $type, $dataObject );
                break;

            case 'trustprocesspending':
                return new \OpenSRS\trust\ProcessPending( $type, $dataObject );
                break;

            case 'trustqueryapproverlist':
                return new \OpenSRS\trust\QueryApproverList( $type, $dataObject );
                break;

            case 'trustrequestondemandscan':
                return new \OpenSRS\trust\RequestOnDemandScan( $type, $dataObject );
                break;

            case 'trustresendapproveremail':
                return new \OpenSRS\trust\ResendApproverEmail( $type, $dataObject );
                break;

            case 'trustresendcertemail':
                return new \OpenSRS\trust\ResendCertEmail( $type, $dataObject );
                break;

            case 'trustupdateorder':
                return new \OpenSRS\trust\UpdateOrder( $type, $dataObject );
                break;

            case 'trustupdateproduct':
                return new \OpenSRS\trust\UpdateProduct( $type, $dataObject );
                break;

            case 'mailauthentication':
                return new \OpenSRS\mail\Authentication( $type, $dataObject );
                break;

            case 'mailchangedomain':
                return new \OpenSRS\mail\ChangeDomain( $type, $dataObject );
                break;

            case 'mailcreatedomainalias':
                return new \OpenSRS\mail\CreateDomainAlias( $type, $dataObject );
                break;

            case 'mailcreatedomain':
                return new \OpenSRS\mail\CreateDomain( $type, $dataObject );
                break;
                
            case 'mailcreatedomainwelcomeemail':
                return new \OpenSRS\mail\CreateDomainWelcomeEmail( $type, $dataObject );
                break;

            case 'mailcreatemailboxforwardonly':
                return new \OpenSRS\mail\CreateMailboxForwardOnly( $type, $dataObject );
                break;

            case 'mailcreatemailbox':
                return new \OpenSRS\mail\CreateMailbox( $type, $dataObject );
                break;

            case 'maildeletedomainalias':
                return new \OpenSRS\mail\DeleteDomainAlias( $type, $dataObject );
                break;

            case 'maildeletedomain':
                return new \OpenSRS\mail\DeleteDomain( $type, $dataObject );
                break;

            case 'maildeletedomainwelcomeemail':
                return new \OpenSRS\mail\DeleteDomainWelcomeEmail( $type, $dataObject );
                break;

            case 'maildeletemailbox':
                return new \OpenSRS\mail\DeleteMailbox( $type, $dataObject );
                break;

            case 'mailgetcompanydomains':
                return new \OpenSRS\mail\GetCompanyDomains( $type, $dataObject );
                break;

            case 'mailgetdomainallowlist':
                return new \OpenSRS\mail\GetDomainAllowList( $type, $dataObject );
                break;

            case 'mailgetdomainblocklist':
                return new \OpenSRS\mail\GetDomainBlockList( $type, $dataObject );
                break;

            case 'mailgetdomainmailboxes':
                return new \OpenSRS\mail\GetDomainMailboxes( $type, $dataObject );
                break;

            case 'mailgetdomainmailboxlimits':
                return new \OpenSRS\mail\GetDomainMailboxLimits( $type, $dataObject );
                break;

            case 'mailgetdomain':
                return new \OpenSRS\mail\GetDomain( $type, $dataObject );
                break;

            case 'mailgetnumdomainmailboxes':
                return new \OpenSRS\mail\GetNumDomainMailboxes( $type, $dataObject );
                break;

            case 'mailsetdomainadmin':
                return new \OpenSRS\mail\SetDomainAdmin( $type, $dataObject );
                break;

            case 'mailsetdomainallowlist':
                return new \OpenSRS\mail\SetDomainAllowList( $type, $dataObject );
                break;

            case 'mailsetdomainblocklist':
                return new \OpenSRS\mail\SetDomainBlockList( $type, $dataObject );
                break;

            case 'mailsetdomaindisabledstatus':
                return new \OpenSRS\mail\SetDomainDisabledStatus( $type, $dataObject );
                break;

            case 'mailsetdomainmailboxlimits':
                return new \OpenSRS\mail\SetDomainMailboxLimits( $type, $dataObject );
                break;

            default:
                throw new Exception( "OSRS Error - $func is unsupported." );
                break;
        }
    }
}
