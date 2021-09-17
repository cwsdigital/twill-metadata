## Twill Metadata

This package is a simple way to add editable SEO metadata to your twill models.  

#### Installation
```shell script
$ composer require cwsdigital/twill-metadata
```

```shell script
$ artisan migrate
```

### In your model

Set your model to use the `HasMetadata` trait, and add the public property `$metadataFallbacks`.
```php
class Page extends Model {

    use HasMetadata;

    public $metadataFallbacks = [];             
...
}

```
### In your controller

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

### In your repository
Add `use HandleMetadata` onto your page repository.

### In your view

In the admin 'form.blade.php' view add the metadata fieldset to the additional fieldsets of the form.
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
    @metadataFields
@stop
```

### Add the global settings form
In your twill-navigation config file add a settings section for the form fields.
```php
// config/twill-navigation.php
<?php

return [
    //...
    'settings' => [
        'title' => 'Settings',
        'route' => 'admin.settings',
        'params' => ['section' => 'general'],
        'primary_navigation' => [
            //...
            'seo' => [
                'title' => 'SEO',
                'route' => 'admin.settings',
                'params' => ['section' => 'seo']
            ],
            //...
        ]
    ],
    //...
];
```

```blade
<!-- views/admin/settings/seo.blade.php -->
@extends('twill::layouts.settings')

@section('contentFields')
    @metadataSettings
@stop
```

### Config & Customisation

You can publish the config for the package with the following command:
```shell script
  php artisan vendor:publish --provider="CwsDigital\TwillMetadata\TwillMetadataServiceProvider" --tag=config
```

Within the config file is a fallbacks array, which can be customised according to your needs.  This is a global config and will apply to all models that use the HasMetadata trait. i.e. in the config below if no description is entered in the metadata description field, the content field on the model will be used as the metadata description (all tags will be stripped).
```php
//Key is the metadata attribute,// 
//Value is the model attribute it will fall back to if metadata value is empty
'fallbacks' => [
        'title' => 'title',
        'description' => 'content',
        'og_title' => 'title',
        'og_description' => 'content',
        'og_type' => 'metadataDefaultOgType',
        'card_type' => 'metadataDefaultCardType',
    ],
```

To provide different fallback configurations to different models with the HasMetadata trait you can use the same array in the public $metadataFallBacks property on the model.
```php
class Page extends Model {

    use HasMetadata;

    public $metadataFallbacks = [
                                'title' => 'name',
                                'description' => 'bio',
                                ];             
...
}
```
The two arrays are merged, so you only need to include the keys you wish to override from the global config.

If you wish to provide a default OpenGraph Type and Twitter Card Type then you can add the following two public properties to your model:

```php
    public $metadataDefaultOgType = 'website';
    public $metadataDefaultCardType = 'summary_large_image';
```

### Setting Meta Tags
In your controller for your front end application you can add the trait `SetsMetadata` and then use the `setMetadata()` function to set the metadata.  

```php
<?php

namespace App\Http\Controllers;

use App\Models\Page;
use CwsDigital\TwillMetadata\Traits\SetsMetadata;

class PageController extends Controller
{
    use setsMetadata;

    public function show($slug) {
        $page = Page::forSlug($slug)->first();
        $this->setMetadata($page);
        return view('site.pages.page', ['page' => $page ]);
    }
}
```

Under the hood this uses the [artesaos/seotools](https://github.com/artesaos/seotools) package to set and display metadata. So you are free to not use the above helper, and manually set the meta tags as required. Or you can use the helper, and then use the methods provided by the package to amend the tags.

### Displaying the meta tags
See the documentation for [artesaos/seotools](https://github.com/artesaos/seotools) for more granular options, but the easiest way is shown below:\
```blade
<html lang="en">
<head>

    {!! SEO::generate() !!}

</head>
```

