<?php

namespace opensrs;

class RequestFactory
{
    public static $RequestRoutes = array(
        'premiumdomain' => 'domains\lookup\PremiumDomain',
        'lookupdomain' => 'domains\lookup\LookupDomain',
        'lookupgetdomain' => 'domains\lookup\GetDomain',
        'lookupgetbalance' => 'account\GetBalance',
        'lookupgetdeleteddomains' => 'domains\lookup\GetDeletedDomains',
        'lookupgetdomainsbyexpiry' => 'domains\lookup\GetDomainsByExpiry',
        'lookupgetdomainscontacts' => 'domains\lookup\GetDomainsContacts',
        'lookupgetnotes' => 'domains\lookup\GetNotes',
        'lookupgetorderinfo' => 'domains\lookup\GetOrderInfo',
        'lookupgetordersbydomain' => 'domains\lookup\GetOrdersByDomain',
        'lookupgetprice' => 'domains\lookup\GetPrice',
        'lookupnamesuggest' => 'domains\lookup\NameSuggest',
        'suggestdomain' => 'domains\lookup\SuggestDomain',
        'lookupbelongstorsp' => 'domains\lookup\BelongsToRsp',
        'allinonedomain' => 'domains\lookup\AllInOneDomain',
        'lookupgetcablockerlist' => 'domains\lookup\GetCaBlockerList',
        'getregistrantverificationstatus' => 'domains\lookup\GetRegistrantVerificationStatus',
        'provswregister' => 'domains\provisioning\SWRegister',
        'provactivate' => 'domains\provisioning\ProvisioningActivate',
        'provcancelactivate' => 'domains\provisioning\ProvisioningCancelActivate',
        'provcancelpending' => 'domains\provisioning\ProvisioningCancelPending',
        'provmodify' => 'domains\provisioning\ProvisioningModify',
        'provprocesspending' => 'domains\provisioning\ProvisioningProcessPending',
        'provqueryqueuedrequest' => 'domains\provisioning\ProvisioningQueryQueuedRequest',
        'provrenew' => 'domains\provisioning\ProvisioningRenew',
        'provrevoke' => 'domains\provisioning\ProvisioningRevoke',
        'provsendciraapproval' => 'domains\provisioning\ProvisioningSendCIRAApproval',
        'provupdateallinfo' => 'domains\provisioning\ProvisioningUpdateAllInfo',
        'provupdatecontacts' => 'domains\provisioning\ProvisioningUpdateContacts',
        'sendregistrantverificationemail' => 'domains\provisioning\SendRegistrantVerificationEmail',
        'subrescreate' => 'domains\subreseller\SubresellerCreate',
        'subresget' => 'domains\subreseller\SubresellerGet',
        'subresmodify' => 'domains\subreseller\SubresellerModify',
        'subrespay' => 'domains\subreseller\SubresellerPay',
        'subuseradd' => 'domains\subuser\SubuserAdd',
        'subuserdelete' => 'domains\subuser\SubuserDelete',
        'subuserget' => 'domains\subuser\SubuserGet',
        'subusergetinfo' => 'domains\subuser\SubuserGetInfo',
        'subusermodify' => 'domains\subuser\SubuserModify',
        'transcancel' => 'domains\transfer\TransferCancel',
        'transcheck' => 'domains\transfer\TransferCheck',
        'transgetaway' => 'domains\transfer\TransferGetAway',
        'transgetin' => 'domains\transfer\TransferGetIn',
        'transprocess' => 'domains\transfer\TransferProcess',
        'transRsp2Rsp' => 'domains\transfer\TransferRsp2Rsp',
        'transsendpass' => 'domains\transfer\TransferSendPassword',
        'transtradedomain' => 'domains\transfer\TransferTradeDomain',
        'fastdomainlookup' => 'fastlookup\FastDomainLookup',
        'authchangeownership' => 'domains\authentication\AuthenticationChangeOwnership',
        'authchangepassword' => 'domains\authentication\AuthenticationChangePassword',
        'authcheckversion' => 'domains\authentication\AuthenticationCheckVersion',
        'authsendauthcode' => 'domains\authentication\AuthenticationSendAuthCode',
        'authsendpassword' => 'domains\authentication\AuthenticationSendPassword',
        'bulkchange' => 'domains\bulkchange\BulkChange',
        'bulksubmit' => 'domains\bulkchange\BulkSubmit',
        'bulktransfer' => 'domains\bulkchange\BulkTransfer',
        'cookiedelete' => 'domains\cookie\CookieDelete',
        'cookiequit' => 'domains\cookie\CookieQuit',
        'cookieset' => 'domains\cookie\CookieSet',
        'cookieupdate' => 'domains\cookie\CookieUpdate',
        'dnscreate' => 'domains\dnszone\DnsCreate',
        'dnsdelete' => 'domains\dnszone\DnsDelete',
        'dnsforce' => 'domains\dnszone\DnsForce',
        'dnsget' => 'domains\dnszone\DnsGet',
        'dnsreset' => 'domains\dnszone\DnsReset',
        'dnsset' => 'domains\dnszone\DnsSet',
        'fwdcreate' => 'domains\forwarding\ForwardingCreate',
        'fwddelete' => 'domains\forwarding\ForwardingDelete',
        'fwdget' => 'domains\forwarding\ForwardingGet',
        'fwdset' => 'domains\forwarding\ForwardingSet',
        'nsadvancedupdt' => 'domains\nameserver\NameserverAdvancedUpdate',
        'nscreate' => 'domains\nameserver\NameserverCreate',
        'nsdelete' => 'domains\nameserver\NameserverDelete',
        'nsget' => 'domains\nameserver\NameserverGet',
        'nsmodify' => 'domains\nameserver\NameserverModify',
        'nsregistryadd' => 'domains\nameserver\NameserverRegistryAdd',
        'nsregistrycheck' => 'domains\nameserver\NameserverRegistryCheck',
        'persdelete' => 'domains\personalnames\PersonalNamesDelete',
        'persnamesuggest' => 'domains\personalnames\PersonalNamesNameSuggest',
        'persquery' => 'domains\personalnames\PersonalNamesQuery',
        'perssuregister' => 'domains\personalnames\PersonalNamesSURegister',
        'persupdate' => 'domains\personalnames\PersonalNamesUpdate',
        'pubcreate' => 'publishing\Create',
        'pubdelete' => 'publishing\Delete',
        'pubdisable' => 'publishing\Disable',
        'pubenable' => 'publishing\Enable',
        'pubgenerateredirectioncode' => 'publishing\GenerateRedirectionCode',
        'pubgetcontrolpanelurl' => 'publishing\GetControlPanelUrl',
        'pubgetserviceinfo' => 'publishing\GetServiceInfo',
        'publetexpire' => 'publishing\LetExpire',
        'pubupdate' => 'publishing\Update',
        'trustcancelorder' => 'trust\CancelOrder',
        'trustcreatetoken' => 'trust\CreateToken',
        'trustgetorderinfo' => 'trust\GetOrderInfo',
        'trustproductinfo' => 'trust\ProductInfo',
        'trustparsecsr' => 'trust\ParseCSR',
        'trustprocesspending' => 'trust\ProcessPending',
        'trustqueryapproverlist' => 'trust\QueryApproverList',
        'trustrequestondemandscan' => 'trust\RequestOnDemandScan',
        'trustresendapproveremail' => 'trust\ResendApproverEmail',
        'trustresendcertemail' => 'trust\ResendCertEmail',
        'trustupdateorder' => 'trust\UpdateOrder',
        'trustupdateproduct' => 'trust\UpdateProduct',
        'mailauthentication' => 'mail\Authentication',
        'mailchangedomain' => 'mail\ChangeDomain',
        'mailcreatedomainalias' => 'mail\CreateDomainAlias',
        'mailcreatedomain' => 'mail\CreateDomain',
        'mailcreatedomainwelcomeemail' => 'mail\CreateDomainWelcomeEmail',
        'mailcreatemailboxforwardonly' => 'mail\CreateMailboxForwardOnly',
        'mailcreatemailbox' => 'mail\CreateMailbox',
        'maildeletedomainalias' => 'mail\DeleteDomainAlias',
        'maildeletedomain' => 'mail\DeleteDomain',
        'maildeletedomainwelcomeemail' => 'mail\DeleteDomainWelcomeEmail',
        'maildeletemailbox' => 'mail\DeleteMailbox',
        'mailgetcompanydomains' => 'mail\GetCompanyDomains',
        'mailgetdomainallowlist' => 'mail\GetDomainAllowList',
        'mailgetdomainblocklist' => 'mail\GetDomainBlockList',
        'mailgetdomainmailboxes' => 'mail\GetDomainMailboxes',
        'mailgetdomainmailboxlimits' => 'mail\GetDomainMailboxLimits',
        'mailgetdomain' => 'mail\GetDomain',
        'mailgetnumdomainmailboxes' => 'mail\GetNumDomainMailboxes',
        'mailsetdomainadmin' => 'mail\SetDomainAdmin',
        'mailsetdomainallowlist' => 'mail\SetDomainAllowList',
        'mailsetdomainblocklist' => 'mail\SetDomainBlockList',
        'mailsetdomaindisabledstatus' => 'mail\SetDomainDisabledStatus',
        'mailsetdomainmailboxlimits' => 'mail\SetDomainMailboxLimits',
        'accountgetbalance' => 'account\GetBalance'
        );

    public static function build($func, $type, $dataObject)
    {
        $route = '';
        $routeKey = strtolower($func);
        $returnFullResponse = true;

        if (array_key_exists($routeKey, self::$RequestRoutes)) {
            $route = self::$RequestRoutes[$routeKey];
        }

        $class = '\opensrs\\'.$route;

        if (class_exists($class)) {
            if (!isset($dataObject->attributes)) {
                $dataconversionRoute = '\opensrs\backwardcompatibility\dataconversion\\'.$route;

                if (class_exists($dataconversionRoute)) {
                    $dc = new $dataconversionRoute();

                    $dataObject = $dc->convertDataObject($dataObject);

                    $returnFullResponse = false;
                }
            }

            return new $class($type, $dataObject, $returnFullResponse);
        } else {
            throw new Exception("OSRS Error - $func is unsupported.");
        }
    }
}
