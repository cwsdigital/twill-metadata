<?php
namespace CwsDigital\TwillMetadata\Traits;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Database\Eloquent\Model;

trait SetsMetadata {

    public function setMetadata(Model $describable, array $metadata=[]) {
        $metadata = $describable->metadata;
        $request = request();

        SEOTools::setTitle($metadata->field('title'));
        SEOTools::setDescription($metadata->field('description'));

        SEOTools::opengraph()->setTitle($metadata->field('og_title'));
        SEOTools::opengraph()->setDescription($metadata->field('og_description'));

        SEOTools::opengraph()->addProperty('type', $metadata->field('og_type'));

        if($metadata->field('og_image')) {
            SEOTools::opengraph()->addImage($metadata->field('og_image'));
        }

        if($metadata->field('canonical_url')) {
            SEOTools::metatags()->setCanonical($metadata->field('canonical_url'));
        }

        $noindex = $metadata->field('noindex');
        $nofollow = $metadata->field('nofollow');

        if( $noindex || $nofollow ) {
            if( $noindex && $nofollow ) {
              SEOTools::metatags()->setRobots('noindex, nofollow');
            } else {
                if($noindex) {
                    SEOTools::metatags()->setRobots('noindex');
                }
                if($nofollow) {
                    SEOTools::metatags()->setRobots('nofollow');
                }
            }
        }
    }

}
