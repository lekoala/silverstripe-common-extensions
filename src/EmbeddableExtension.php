<?php

namespace LeKoala\CommonExtensions;

use Exception;
use Embed\Embed;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;

/**
 * Embed external url on this data object
 *
 * @property DataObject|\LeKoala\CommonExtensions\EmbeddableExtension $owner
 * @property string $EmbedURL
 */
class EmbeddableExtension extends DataExtension
{
    private static $db = [
        "EmbedURL" => "Varchar(255)"
    ];
    private static $casting = array(
        "EmbedURL" => "HTMLFragment",
    );

    public function updateCMSFields(FieldList $fields)
    {
        $EmbedURL = $fields->dataFieldByName('EmbedURL');
        if ($EmbedURL) {
            $EmbedURL->setTitle(_t('EmbeddableExtension.EMBEDURL', 'Embed from URL'));
            $EmbedURL->setDescription(_t('EmbeddableExtension.EMBEDURLDESC', 'Copy the url of a compatible ressource (eg: a Youtube video)'));

            // Position properly
            $Content = $fields->dataFieldByName('Content');
            if ($Content) {
                $fields->insertAfter('Content', $EmbedURL);
            }
            $Description = $fields->dataFieldByName('Description');
            if ($Description) {
                $fields->insertAfter('Description', $EmbedURL);
            }
        }
    }

    public function validate(ValidationResult $validationResult)
    {
        if ($this->owner->EmbedURL) {
            try {
                $embed = Embed::create($this->owner->EmbedURL);
            } catch (Exception $ex) {
                $validationResult->addError($ex->getMessage());
            }
        }
    }

    public function EmbeddedContent()
    {
        $embed = Embed::create($this->owner->EmbedURL);
        $html = $embed->code;
        return $html;
    }
}
