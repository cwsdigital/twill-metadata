<?php

namespace CwsDigital\TwillMetadata\Models;

use A17\Twill\Repositories\SettingRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Metadata extends Model
{

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


    public function meta_describable() {
        return $this->morphTo();
    }

//    //TODO - naming of this method?
//    public function full() {
//        $metadata = [];
//        $exclude = ['id', 'created_at', 'updated_at', 'meta_describable_id', 'meta_describable_type', 'og_image'];
//        $columns = array_diff($this->getTableColumns(), $exclude);
//        foreach($columns as $column){
//            $metadata[$column] = $this->field($column);
//        }
//
//        $metadata['image'] = $this->meta_describable->getSocialImageAttribute();
//
//        return $metadata;
//    }

    public function field($column)
    {
        switch($column) {
            case 'og_image':
                return $this->meta_describable->getSocialImageAttribute();
                break;
            case 'noindex':
            case 'nofollow':
                return $this->$column;
                break;
        }

        if (!empty($this->$column)) {
            switch( $column) {

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

    protected function getFallbackValue($column) {
        if( !array_key_exists($column, $this->fallbacks()) ) {
            return;
        }

        $fallback = $this->fallbacks()[$column];
        if($column == 'title' || $column == 'og_title') {
            $site_title = app(SettingRepository::class)->byKey('site_title', 'seo');
            return strip_tags($this->meta_describable->$fallback) . ($site_title ? ' - '. $site_title : '');
        } else {
            return strip_tags($this->meta_describable->$fallback);
        }
    }

    protected function fallbacks() {
        return $this->meta_describable->metadataFallbacks;
    }

    /*
     * Return the meta content value from given og_type id value
     */
    protected function getOgTypeContent($id) {
        $og_types = config('metadata.opengraph_type_options');
        $key = array_search($id, array_column($og_types, 'value'));
        return $og_types[$key]['label'];
    }

    /*
     * Return the meta content value from given card_type id value
     */
    protected function getCardTypeContent($id) {
        $og_types = config('metadata.card_type_options');
        $key = array_search($id, array_column($og_types, 'value'));
        return $og_types[$key]['label'];
    }


    private function getTableColumns() {
        return Schema::getColumnListing($this->getTable());
    }

}
