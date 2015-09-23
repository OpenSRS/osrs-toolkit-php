<?php


namespace opensrs;

class Exception extends \Exception
{
    public static function notDefined($propertyName)
    {
        throw new self("oSRS Error - $propertyName is not defined.");
    }

    public static function classNotFound($class)
    {
        throw new self("The class $class does not exist or cannot be found");
    }

    public static function cannotSetOneCall($string)
    {
        throw new self("oSRS Error - $string cannot be set in one call");
    }
}
