<?php

namespace LeKoala\CommonExtensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Security;

/**
 * Track who edited what
 *
 * @property \LeKoala\CommonExtensions\EditorTrackingExtension|\SilverStripe\ORM\DataObject $owner
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

    public function updateCMSFields(FieldList $fields)
    {
        $CreatedByID = $fields->dataFieldByName('CreatedByID');
        if ($CreatedByID) {
            $fields->replaceField('CreatedByID', $CreatedByID->performReadonlyTransformation());
        }
        $LastEditedByID = $fields->dataFieldByName('LastEditedByID');
        if ($LastEditedByID) {
            $fields->replaceField('LastEditedByID', $LastEditedByID->performReadonlyTransformation());
        }
    }
}
