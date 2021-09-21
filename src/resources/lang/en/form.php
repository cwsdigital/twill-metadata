<?php

return [
    'titles' => [
        'fieldset' => 'SEO',
        'advanced_settings' => 'Advanced Settings',
        'advanced_description' => 'Edit nofollow, noindex and canonical url',
        'sharing_settings' => 'Social Sharing Settings',
        'sharing_description' => 'Customise how your content appears when shared on social media',
    ],
    'fields' => [
        'title' => [
            'label' => 'Meta Title',
            'note' => 'Recommended length 40 - 60 characters',
            ],
        'description' => [
            'label' => 'Meta Description',
            'note' => 'Recommended length 80 - 120 characters',
        ],
        'noindex' => [
            'label' => 'Tell search engines not to index this page (noindex tag).',
        ],
        'nofollow' => [
            'label' => 'Tell search engines not to follow links on this page (nofollow tag).'
        ],
        'canonical_url' => [
            'label' => 'Canonical URL',
            'note' => 'Only populate this field if the canonical url is different to the site url',
        ],
        'og_image' => [
            'label' => 'Social Image',
            'note' => 'Specify a custom image for Twitter and Facebook cards (recommended width 1200px)',
        ],
        'og_title' => [
            'label' => 'Social Title',
            'note' => 'Provide a custom title (defaults to the meta title if blank)',
        ],
        'og_description' => [
            'label' => 'Social Description',
            'note' => 'Provide a custom description (defaults to the meta description if blank)',
        ],
        'og_card_type' => [
            'label' => 'Twitter Card Style',
            'placeholder' => 'Select a style',
        ],
        'og_type' => [
            'label' => 'Opengraph Content Type',
            'placeholder' => 'Select a type',
        ],
    ],
];