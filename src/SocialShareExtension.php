<?php

namespace LeKoala\CommonExtensions;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;

/**
 * Easily add share urls based on Link method
 *
 * Typically you will need an AbsoluteLink method as well because it should
 * be available in sitemap
 *
 * https://github.com/wilr/silverstripe-googlesitemaps/blob/master/docs/en/index.md
 *
 * @link http://www.sharelinkgenerator.com/
 * @property \SilverStripe\CMS\Model\SiteTree $owner
 */
class SocialShareExtension extends DataExtension
{
    protected function getSocialAbsoluteLink($obj)
    {
        if ($obj->hasMethod('AbsoluteLink')) {
            $link = $obj->AbsoluteLink();
        } elseif ($obj->hasMethod('Link')) {
            $link = Director::absoluteURL($obj->Link());
        } else {
            $link = Controller::curr()->getRequest()->getURL();
        }
        return $link;
    }

    public function FacebookShareUrl()
    {
        $link = $this->getSocialAbsoluteLink($this->owner);
        return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($link);
    }

    public function TwitterShareUrl()
    {
        $link = $this->getSocialAbsoluteLink($this->owner);
        return 'http://twitter.com/share?url=' . urlencode($link) . '&text=' . urlencode($this->owner->Title);
    }

    public function LinkedInShareUrl()
    {
        $link = $this->getSocialAbsoluteLink($this->owner);
        return 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($link);
    }

    public function EmailShareLink()
    {
        $link = $this->getSocialAbsoluteLink($this->owner);
        $body = _t('SocialExtension.DISCOVER', 'I discovered ') . ' "' . $this->owner->Title . '" \n' .
            _t('SocialExtension.SEE', 'You can see it here :') . ' ' . $link;
        return 'mailto:?subject=' . $this->owner->Title . '&body=' . htmlentities($body);
    }
}
