<?php

return [
    'fields' => [
        'title',
        'description',
        'og_title',
        'og_description',
        'og_type',
        'card_type'
    ],

    'fallbacks' => [
        'title' => 'title',
        'description' => 'content',
        'og_title' => 'title',
        'og_description' => 'content',
        'og_type' => 'metadataDefaultOgType',
        'card_type' => 'metadataDefaultCardType',
        'og_image' => [],
    ],

    'opengraph_type_options' => [
        ['value' => 1, 'content' =>'website', 'label' => 'Website',],
        ['value' => 2, 'content' => 'article','label' => 'Article',],
        ['value' => 3, 'content' => 'book', 'label' => 'Book',],
        ['value' => 4, 'content' => 'profile', 'label' => 'Profile'],
    ],



    'card_type_options' => [
        [ 'value' => 1, 'content' => 'summary', 'label' => 'Summary',],
        [ 'value' => 2, 'content' => 'summary_large_image','label' => 'Summary with Large Image',],
        [ 'value' => 3, 'content' => 'app', 'label' => 'App',],
        [ 'value' => 4, 'content' => 'player', 'label' => 'Player'],
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
                    ]
                ]
            ],

        ]
    ]
];
