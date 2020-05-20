## Twill Metadata

This package is a simple way to add editable SEO metadata to your twill models.  

#### Installation
```shell script
$ composer require cwsdigital/twill-metadata
```

```shell script
$ artisan migrate
```

publish config

Add `use HasMetadata;` to your model.

Add `public $metadataFallbacks = [];` to your model.

In the Twill admin controller for the model, ensure the `metadata_card_type_options` and `metadata_og_type_options` are set in the `formData()` method.
```php
protected function formData($request)
    {
        return [
            'metadata_card_type_options' => config('metadata.card_type_options'),
            'metadata_og_type_options' => config('metadata.opengraph_type_options'),
        ];
    }
```

Add `use HandleMetadata` onto your page repository.

In your 'form.blade.php' view add the metadata fieldset to the additional fieldsets of the form
```blade
@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'metadata', 'label' => 'Custom Title'],
    ]
])

@section('contentFields')
...your other form fields
@stop

@section('fieldsets')
    @metadata
@stop
```
