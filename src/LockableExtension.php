<?php

namespace LeKoala\CommonExtensions;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use LeKoala\CmsActions\CustomAction;

/**
 * Makes record locked
 *
 * Unlocking require special action
 *
 * @property \LeKoala\CommonExtensions\LockableExtension|DataObject $owner
 * @property boolean $IsLocked
 */
class LockableExtension extends DataExtension
{
    private static $db = [
        "IsLocked" => "Boolean"
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('IsLocked');
    }

    /**
     *  Use this in your model. It has to run last and cannot be done automatically
     *
     *  if($this->hasExtension(LockableExtension::class)) {
     *     $this->lockFields($fields);
     *  }
     *
     * @param FieldList $fields
     * @return void
     */
    public function lockFields(FieldList $fields)
    {
        if (!$this->owner->IsLocked) {
            return;
        }
        $fields->makeReadonly();
    }

    public function canEdit($member)
    {
        if ($this->owner->IsLocked) {
            return false;
        }
        return parent::canEdit($member);
    }

    public function updateCMSActions(FieldList $actions)
    {
        if ($this->owner->ID && !$this->owner->IsLocked) {
            $lockRecord = new CustomAction("LockRecord", "Lock");
            $lockRecord->setConfirmation("Are you sure to lock this record?");
            $actions->push($lockRecord);
        }
    }

    public function LockRecord($data, $form, $controller)
    {
        $this->owner->IsLocked = true;
        $this->owner->write();

        return 'Record locked';
    }
}
