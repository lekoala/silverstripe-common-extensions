<?php

namespace LeKoala\CommonExtensions;

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
    public function FacebookShareUrl()
    {
        $link = $this->owner->AbsoluteLink();
        return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($link);
    }

    public function TwitterShareUrl()
    {
        $link = $this->owner->AbsoluteLink();
        return 'http://twitter.com/share?url=' . urlencode($link) . '&text=' . urlencode($this->owner->Title);
    }

    public function LinkedInShareUrl()
    {
        $link = $this->owner->AbsoluteLink();
        return 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($link);
    }

    public function EmailShareLink()
    {
        $link = $this->owner->AbsoluteLink();
        $body = _t('SocialExtension.DISCOVER', 'I discovered ') . ' "' . $this->owner->Title . '" \n' .
            _t('SocialExtension.SEE', 'You can see it here :') . ' ' . $link;
        return 'mailto:?subject=' . $this->owner->Title . '&body=' . htmlentities($body);
    }
}
