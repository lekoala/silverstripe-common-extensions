<?php

namespace LeKoala\CommonExtensions\Test;

use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;
use LeKoala\Base\Extensions\IPExtension;
use LeKoala\Base\ORM\FieldType\DBCountry;

class Test_CommonExtensions extends DataObject implements TestOnly
{
    private static $db = [
        "Phone" => "Varchar(51)",
        "CountryCode" => DBCountry::class,
    ];
    private static $table_name = 'CommonExtensions';
    private static $extensions = [
        IPExtension::class,
    ];
}
