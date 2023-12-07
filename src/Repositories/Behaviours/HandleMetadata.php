<?php

namespace CwsDigital\TwillMetadata\Repositories\Behaviours;

use A17\Twill\Models\Contracts\TwillModelContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait HandleMetadata
{
    // Prefix for metadata fields in form
    protected string $metadataFieldPrefix = 'metadata';

    // Fields with fixed default values that we want persisting to store if blank
    // N.B. this does not include those fields that fallback to another field when blank
    protected array $withDefaultValues = ['card_type', 'og_type'];

    /**
     * Handle saving of metadata fields from form submission.
     *
     * @param \A17\Twill\Models\Contracts\TwillModelContract $object
     * @param array                                          $fields
     */
    public function afterSaveHandleMetadata(TwillModelContract $object, array $fields)
    {
        // Due to the way twill handles adding data to VueX store
        // metadata will come through in individual fields metadata[title]... not in an array
        $fields = $this->getMetadataFields($fields);

        $fields = $this->setFieldDefaults($object, $fields);

        $repository = App::make('CwsDigital\TwillMetadata\Repositories\MetadataRepository');

        $metadata = $object->metadata ?? $object->metadata()->create();

        $repository->update($metadata->id, $fields);
    }

    /**
     * Prepares the metadata fields for the admin form view.
     *
     * @param \A17\Twill\Models\Contracts\TwillModelContract $object
     * @param array                                          $fields
     *
     * @return array
     */
    public function getFormFieldsHandleMetadata(TwillModelContract $object, array $fields)
    {
        // If the metadata object doesn't exist create it.  Every 'meta_describable' will need one entry.
        $metadata = $object->metadata ?? $object->metadata()->create();

        $metadata = $this->setFieldDefaults($object, $metadata);

        $fields['metadata'] = $metadata->attributesToArray();

        if ($metadata->translations != null && $metadata->translatedAttributes != null) {
            foreach ($metadata->translations as $translation) {
                foreach ($metadata->translatedAttributes as $attribute) {
                    unset($fields[$attribute]);
                    $fields['translations']["metadata[{$attribute}]"][$translation->locale] = $translation->{$attribute};
                }
            }
        }

        return $fields;
    }

    /**
     * Filters the full fields array down to just the metadata fields
     * removes the field prefix and sets the keys correctly for persisting to store.
     *
     * @param array $fields
     *
     * @return array
     */
    protected function getMetadataFields(array $fields)
    {
        $metadataFields = [];
        foreach ($fields as $key => $value) {
            if ($this->isMetadataField($key)) {
                // transform metadata[xxxx] to xxxx
                $newKey = preg_replace('/'.$this->metadataFieldPrefix.'\[([^\]]*)\]/', '$1', $key);
                $metadataFields[$newKey] = $value;
            }
        }

        return $metadataFields;
    }

    /**
     * Set default values on fields that require it.
     *
     * @param \A17\Twill\Models\Contracts\TwillModelContract $object
     * @param array                                          $fields
     *
     * @return array
     */
    protected function setFieldDefaults(TwillModelContract $object, $fields)
    {
        foreach ($this->withDefaultValues as $fieldName) {
            if (empty($fields[$fieldName])) {
                $property = 'metadataDefault'.Str::studly($fieldName);
                $fields[$fieldName] = $object->$property;
            }
        }

        return $fields;
    }

    /**
     * Determine if the field belongs to the metadata.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isMetadataField(string $key)
    {
        return Str::startsWith($key, $this->metadataFieldPrefix);
    }
}
