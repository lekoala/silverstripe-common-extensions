<?php

namespace LeKoala\CommonExtensions;

use SilverStripe\Security\Member;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Security;

/**
 * Track who edited what
 *
 * @property \LeKoala\CommonExtensions\EditorTrackingExtension $owner
 * @property int $CreatedByID
 * @property int $LastEditedByID
 * @method \SilverStripe\Security\Member CreatedBy()
 * @method \SilverStripe\Security\Member LastEditedBy()
 */
class EditorTrackingExtension extends DataExtension
{
    private static $has_one = [
        "CreatedBy" => Member::class,
        "LastEditedBy" => Member::class,
    ];

    public function onBeforeWrite()
    {
        $user = Security::getCurrentUser();
        if (!$this->owner->ID) {
            $this->owner->CreatedBy = $user->ID ?? 0;
        }
        $this->owner->LastEditedBy = $user->ID ?? 0;
    }
}
