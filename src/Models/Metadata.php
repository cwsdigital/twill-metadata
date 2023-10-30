<?php

namespace CwsDigital\TwillMetadata\Models;

use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Model;
use Illuminate\Support\Facades\Schema;

class Metadata extends Model
{
    use HasTranslation;

    public $translationModel = 'CwsDigital\TwillMetadata\Models\Translations\MetadataTranslation';

    public $translatedAttributes = [
        'title',
        'description',
        'og_title',
        'og_description',
        'canonical_url',
    ];

    public $fillable = [
        'title',
        'description',
        'og_title',
        'og_description',
        'og_type',
        'card_type',
        'noindex',
        'nofollow',
        'canonical_url',
    ];

    public function meta_describable()
    {
        return $this->morphTo();
    }

    public function field($column)
    {
        switch ($column) {
            case 'og_image':
                return $this->meta_describable->getSocialImageAttribute();
                break;
            case 'noindex':
            case 'nofollow':
                return $this->$column;
                break;
        }

        if (! empty($this->$column)) {
            switch ($column) {
                case 'og_type':
                    return $this->getOgTypeContent($this->$column);
                    break;
                case 'card_type':
                    return $this->getCardTypeContent($this->$column);
                    break;
                default:
                    return $this->$column;
            }
        } else {
            return $this->getFallbackValue($column);
        }
    }

    protected function getOgTypeContent($id)
    {
        $og_types = config('metadata.opengraph_type_options');
        $key = array_search($id, array_column($og_types, 'value'));

        return $og_types[$key]['label'];
    }

    protected function getCardTypeContent($id)
    {
        $og_types = config('metadata.card_type_options');
        $key = array_search($id, array_column($og_types, 'value'));

        return $og_types[$key]['label'];
    }

    /*
     * Return the meta content value from given og_type id value
     */
    protected function getFallbackValue($columnName)
    {
        if (! array_key_exists($columnName, $this->fallbacks())) {
            return false;
        }

        $fallbackColumnName = $this->fallbacks()[$columnName];

        // For opengraph title fall back to meta title
        if ($columnName == 'og_title') {
            return $this->field('title');
        }

        // For opengraph description fall back to meta description
        if ($columnName == 'og_description') {
            return $this->field('description');
        }

        // For title, we'll use the fallback column and append the site title too.
        if ($columnName == 'title') {
            $siteTitle = TwillAppSettings::getTranslated('seo.metadata.site_title');
            return strip_tags($this->meta_describable->$fallbackColumnName).($siteTitle ? ' - '.$siteTitle : '');
        }

        // otherwise simply use the fallback column value
        return strip_tags($this->meta_describable->$fallbackColumnName);
    }

    /*
     * Return the meta content value from given card_type id value
     */
    protected function fallbacks()
    {
        return $this->meta_describable->metadataFallbacks;
    }

    private function getTableColumns()
    {
        return Schema::getColumnListing($this->getTable());
    }
}
