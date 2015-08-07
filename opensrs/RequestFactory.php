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
        } 
    }
}
