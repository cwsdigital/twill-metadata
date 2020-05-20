<?php

namespace CwsDigital\TwillMetadata\Repositories\Behaviours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HandleMetadata {
    // Prefix for metadata fields in form
    protected $metadataFieldPrefix = 'metadata';

    // Fields with fixed default values that we want persisting to store if blank
    // N.B. this does not include those fields that fallback to another field when blank
    protected $withDefaultValues = ['card_type', 'og_type'];

    /**
     * Handle saving of metadata fields from form submission
     *
     * @param Model $object
     * @param array $fields
     */
    public function beforeSaveHandleMetadata(Model $object, array $fields)
    {
        //request has already been validated? OR should we do some validation here?
        //$fields now contains an array of metadata fields !! process it!
        $metadata = array_key_exists('metadata',$fields) ? $fields['metadata'] : null;
        if( isset($metadata) && is_array($metadata) && !empty($metadata)) {
            $metadata = $this->setFieldDefaults($object, $metadata);
            $object->metadata()->update($metadata);
        }
    }

    //Metadata has already been saved, and attribute not valid on parent
    public function prepareFieldsBeforeSaveHandleMetadata($object, $fields) {
        unset($fields['metadata']);
        return $fields;
    }

    /**
     * Prepares the metadata fields for the admin form view
     *
     * @param Model $object
     * @param array $fields
     * @return array
     */
    public function getFormFieldsHandleMetadata(Model $object, array $fields){
        //If the metadata object doesn't exist create it.  Every 'meta_describable' will need one entry.
        $metadata = $object->metadata ?? $object->metadata()->create();
        $metadata = $this->setFieldDefaults($object, $metadata);
        $fields['metadata'] = $metadata->attributesToArray();
        return $fields;
    }

    /**
     * Filters the full fields array down to just the metadata fields
     * removes the field prefix and sets the keys correctly for persisting to store
     *
     * @param array $fields
     * @return array
     */
//    protected function getMetadataFields(array $fields) {
//        $metadataFields = [];
//        foreach ( $fields as $key => $value) {
//            if( $this->isMetadataField($key) ) {
//                // transform metadata[xxxx] to xxxx
//                $newKey = preg_replace('/'. $this->metadataFieldPrefix .'\[([^\]]*)\]/', '$1', $key);
//                $metadataFields[$newKey] = $value;
//            }
//        }
//        return $metadataFields;
//    }

    /**
     * Set default values on fields that require it
     *
     * @param Model $object
     * @param array $fields
     * @return array
     */
    protected function setFieldDefaults( Model $object, $fields) {
        foreach( $this->withDefaultValues as $fieldName) {
            if( empty($fields[$fieldName]) ) {
                $property = 'metadataDefault'.Str::studly($fieldName);
                $fields[$fieldName] = $object->$property;
            }
        }
        return $fields;
    }

}
