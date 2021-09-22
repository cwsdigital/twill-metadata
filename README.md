# Twill Metadata

This package is a simple way to add SEO metadata to your [Twill](https://twill.io/) models by providing a drop-in fieldset to add all the required fields into your model edit form.  With sensible defaults, configurable fallbacks, and a global settings screen; this package should meet most of the needs for optimising meta tags within a site.

![default and expanded views of twill metadata fieldset](https://github.com/cwsdigital/twill-metadata/blob/master/Twill-Metadata-Preview.jpg)

## Installation
```shell script
$ composer require cwsdigital/twill-metadata
```

```shell script
$ artisan migrate
```

## Upgrade Notes
**v1.0.0**<br />
This version introduces support for translated metadata.  This means if you are upgrading from pre-v1.x version in an existing site with content you will need to migrate your content from the columns on the `metadata` table to the `metadata_translations` table.  


**v1.1.0**<br />
This version drops the translated columns from the `metadata` table. 

**WARNING! Do not upgrade to v1.1.x from a pre-1.0 installation on an existing site with content. YOU WILL LOSE DATA.**

If you wish to upgrade to this version, upgrade to v1.0.0 first, then perform any content migrations required.  Only once you have moved all translatable data from the `metadata` table to the `metadata_translations` table should you upgrade to v1.1.x.

## Configuration

### In the model

Set your model to use the `HasMetadata` trait, and add the public property `$metadataFallbacks`. 
Your model also need to use the HasMedias trait in order to allow for OpenGraph images.
```php
// App/Models/Page.php
class Page extends Model {

    use HasMetadata;
    use HasMedias;

    public $metadataFallbacks = [];             
...
}

```
### In the controller

In the Twill admin controller for the model, ensure the `metadata_card_type_options` and `metadata_og_type_options` are set in the `formData()` method.
```php
// App/Http/Controllers/Admin/PageController.php
protected function formData($request)
    {
        return [
            'metadata_card_type_options' => config('metadata.card_type_options'),
            'metadata_og_type_options' => config('metadata.opengraph_type_options'),
        ];
    }
```

### In the repository
Add `use HandleMetadata` onto your page repository.
```php
// App/Repositories/PageRepository.php
class PageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleMetadata;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }
}
```

### In the view
#### Add the fieldset to your form
In the admin 'form.blade.php' view add the metadata fieldset to the additional fieldsets section of the form.
```blade
{{-- resources/views/admin/pages/form.blade.php --}}
@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'metadata', 'label' => 'SEO'],
    ]
])

@section('contentFields')
...your other form fields
@stop

@section('fieldsets')
    @metadataFields
@stop
```

#### Add the global settings form
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
{{-- views/admin/settings/seo.blade.php --}}
@extends('twill::layouts.settings')

@section('contentFields')
    @metadataSettings
@stop
```


## Setting meta tags
In your controller for your front end application you can add the trait `SetsMetadata` and then use the `setMetadata()` function to set the metadata.  

```php
<?php
// App/Http/Controllers/PageController.php
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

## Outputting meta tags
See the documentation for [artesaos/seotools](https://github.com/artesaos/seotools) for more granular options, but the easiest way is shown below:
```blade
{{-- resources/views/layouts/site.blade.php --}}
<html lang="en">
<head>

    {!! SEO::generate() !!}

</head>
```

## Customization

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
        'og_type' => 'metadataDefaultOgType',
        'card_type' => 'metadataDefaultCardType',
    ],
```

To provide different fallback configurations to different models with the HasMetadata trait you can use the same array in the public $metadataFallBacks property on the model.
```php
// App/Models/Page.php
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

You can publish the views for the package with the following command:
```shell script
  php artisan vendor:publish --provider="CwsDigital\TwillMetadata\TwillMetadataServiceProvider" --tag=views
```

You can publish the language files for the package with the following command:
```shell script
  php artisan vendor:publish --provider="CwsDigital\TwillMetadata\TwillMetadataServiceProvider" --tag=lang
```
