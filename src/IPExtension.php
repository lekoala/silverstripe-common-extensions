<?php

namespace LeKoala\CommonExtensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;

/**
 * Store IP v4 in plain text (easier to read from the db)
 * For IP v4 + v6 and more efficient storage, use BinaryIPExtension
 *
 * @property \LeKoala\CommonExtensions\IPExtension $owner
 * @property string $IP
 */
class IPExtension extends DataExtension
{
    /**
     * @var array<string,string>
     */
    private static $db = [
        "IP" => "Varchar(45)"
    ];

    /**
     * @return void
     */
    public function onBeforeWrite()
    {
        if (!Controller::has_curr()) {
            return;
        }
        $controller = Controller::curr();
        // This is best used when IP is set on creation
        if (!$this->owner->IP) {
            $ip = $controller->getRequest()->getIP();
            $this->owner->IP = $ip;
        }
    }

    /**
     * @return \LeKoala\GeoTools\Models\Address|null
     */
    public function getIpLocationDetails()
    {
        if (!$this->owner->IP) {
            return null;
        }
        if (interface_exists("\\LeKoala\\Geo\\Services\\Geolocator")) {
            $geolocator = Injector::inst()->get("\\LeKoala\\Geo\\Services\\Geolocator");
            return $geolocator->geolocate($this->owner->IP);
        }
        return null;
    }
}
