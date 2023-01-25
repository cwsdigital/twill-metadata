<?php

return [

    'fallbacks' => [
        'title' => 'title',
        'description' => false,
        'og_type' => 'metadataDefaultOgType',
        'card_type' => 'metadataDefaultCardType',
    ],

    'opengraph_type_options' => [
        ['value' => 'website', 'label' => 'Website'],
        ['value' => 'article', 'label' => 'Article'],
        ['value' => 'book', 'label' => 'Book'],
        ['value' => 'profile', 'label' => 'Profile'],
    ],

    'card_type_options' => [
        ['value' => 'summary', 'label' => 'Summary'],
        ['value' => 'summary_large_image', 'label' => 'Summary with Large Image'],
        ['value' => 'app', 'label' => 'App'],
        ['value' => 'player', 'label' => 'Player'],
    ],

    'mediasParams' => [
        'og_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1.91 / 1,
                    'minValues' => [
                        'width' => 1200,
                        'height' => 627,
                    ],
                ],
            ],

        ],
    ],
];
