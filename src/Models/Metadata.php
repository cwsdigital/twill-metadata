<?php

namespace CwsDigital\TwillMetadata\Models;

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
    ];
    //

    // Return opengraph type id from content value
//    public static function og_type_id($type) {
//        $og_types = config('metadata.opengraph_type_options');
//        $key = array_search($type, array_column($og_types, 'content'));
//        return $og_types[$key]['value'];
//    }
//
//    //return card type id from content value
//    public static function card_type_id($type) {
//        $og_types = config('metadata.card_type_options');
//        $key = array_search($type, array_column($og_types, 'content'));
//        return $og_types[$key]['value'];
//    }

    public function meta_describable() {
        return $this->morphTo();
    }

    //TODO - naming of this method?
    public function full() {
        $metadata = [];
        $exclude = ['id', 'created_at', 'updated_at', 'meta_describable_id', 'meta_describable_type', 'og_image'];
        $columns = array_diff($this->getTableColumns(), $exclude);
        foreach($columns as $column){
            $metadata[$column] = $this->field($column);
        }

        $metadata['image'] = $this->meta_describable->getSocialImageAttribute();

        return $metadata;
    }

    public function field($column)
    {
        if (!empty($this->$column)) {
            switch( $column) {
//                case 'og_type':
//                    return $this->getOgTypeContent($this->$column);
//                    break;
//                case 'card_type':
//                    return $this->getCardTypeContent($this->$column);
//                    break;
                default:
                    return $this->$column;
            }
        } else {
            return $this->getFallbackValue($column);
        }
    }

    protected function getFallbackValue($column) {
        $fallback = $this->fallbacks()[$column];
        return $this->meta_describable->$fallback;
    }

    protected function fallbacks() {
        return $this->meta_describable->metadataFallbacks;
    }

    /*
     * Return the meta content value from given og_type id value
     */
//    protected function getOgTypeContent($id) {
//        $og_types = config('metadata.opengraph_type_options');
//        $key = array_search($id, array_column($og_types, 'value'));
//        return $og_types[$key]['content'];
//    }
//
//    /*
//     * Return the meta content value from given card_type id value
//     */
//    protected function getCardTypeContent($id) {
//        $og_types = config('metadata.card_type_options');
//        $key = array_search($id, array_column($og_types, 'value'));
//        return $og_types[$key]['content'];
//    }


    private function getTableColumns() {
        return Schema::getColumnListing($this->getTable());
    }

}
