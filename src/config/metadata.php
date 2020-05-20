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
        [ 'value' =>'website', 'label' => 'Website',],
        [ 'value' => 'article','label' => 'Article',],
        [ 'value' => 'book', 'label' => 'Book',],
        [ 'value' => 'profile', 'label' => 'Profile'],
    ],



    'card_type_options' => [
        [  'value' => 'summary', 'label' => 'Summary',],
        [  'value' => 'summary_large_image','label' => 'Summary with Large Image',],
        [  'value' => 'app', 'label' => 'App',],
        [  'value' => 'player', 'label' => 'Player'],
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
