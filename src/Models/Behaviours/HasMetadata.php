<?php


namespace CwsDigital\TwillMetadata\Models\Behaviours;


trait HasMetadata {

    public $hasMetadata = true;

    public function metadata() {
        return $this->morphOne('CwsDigital\TwillMetadata\Models\Metadata', 'meta_describable');
    }

    public function getSocialImageAttribute() {
        if ( $this->hasImage('og_image') ) {
            return $this->socialImage('og_image');
        } elseif( $this->hasSpecifiedMetaFallbackImage('og_image') ) {
            return $this->getSpecifiedMetadataFallbackImage('og_image');
        } elseif ( $this->hasAnyImages() ) {
            return $this->getDefaultMetadataFallbackImage();
        }
    }


    public function hasSpecifiedMetaFallbackImage($key) {
        if( array_key_exists($key, $this->metadataFallbacks ) ) {
            return (
                !empty($this->metadataFallbacks[$key]) &&
                is_array($this->metadataFallbacks[$key]) &&
                array_key_exists('role', $this->metadataFallbacks[$key]) &&
                array_key_exists('crop', $this->metadataFallbacks[$key])
            );
        } else {
            return false;
        }
    }

    public function getSpecifiedMetadataFallbackImage($key) {
        $role = $this->metadataFallbacks[$key]['role'];
        $crop = $this->metadataFallbacks[$key]['crop'];

        return $this->socialImage($role, $crop, [], true);
    }

    public function getDefaultMetadataFallbackImage() {
        if ( $this->hasAnyMedias() ) {
            $media = $this->medias()->first();
            return $this->socialImage($media->pivot->role, $media->pivot->crop, [], true);
        } elseif ( $this->hasAnyBlockMedias() ) {
            $block = $this->blocks()->has('medias')->first();
            $media = $block->medias()->first();
            return $block->socialImage($media->pivot->role, $media->pivot->crop, [], true);
        }
    }

    public function hasAnyImages() {
        return $this->hasAnyMedias() || $this->hasAnyBlockMedias();
    }

    protected function initializeHasMetadata()
    {
        // Setup the array for fallback columns
        $this->metadataFallbacks = array_merge(config('metadata.fallbacks'), $this->metadataFallbacks);

        // Add the default metadata from config into the $mediasParams array
        // by default adds in an 'og_image' role with a 'default' crop
        $this->mediasParams = array_merge($this->mediasParams, config('metadata.mediasParams') );
    }

    public function usesTrait($trait) {
        return array_key_exists($trait, class_uses($this));
    }

    public function hasAnyMedias() {
        $hasMedias = $this->usesTrait('A17\Twill\Models\Behaviors\HasMedias');
        return $hasMedias ? $this->medias()->count() : 0;
    }

    public function hasAnyBlockMedias() {
        $hasBlocks = $this->usesTrait('A17\Twill\Models\Behaviors\HasBlocks');
        return $hasBlocks ? $this->blocks()->has('medias')->count() : 0;
    }
}
