<?php
namespace CwsDigital\TwillMetadata\Traits;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Database\Eloquent\Model;

trait SetsMetadata {

    public function setMetadata(Model $describable) {
        $metadata = $describable->metadata;

        if(!$metadata) return; // Prevent errors if model has no attached metadata

        SEOTools::setTitle($metadata->field('title'));

        if( $metadata->field('description') ) {
            SEOTools::setDescription($metadata->field('description'));
        }

        SEOTools::opengraph()->setTitle($metadata->field('og_title'));

        if($metadata->field('og_description')) {
            SEOTools::opengraph()->setDescription($metadata->field('og_description'));
        }

        SEOTools::opengraph()->addProperty('type', $metadata->field('og_type'));

        if($metadata->field('og_image')) {
            SEOTools::opengraph()->addImage($metadata->field('og_image'));
        }

        SEOTools::opengraph()->setUrl(request()->url());

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
