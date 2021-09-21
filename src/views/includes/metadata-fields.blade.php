@if( $item->hasMetadata )
    <x-formFieldset title="SEO Details" id="metadata">
        @formField('input', [
        'name' => 'metadata[title]',
        'label' => 'Meta Title',
        'note' => 'Recommended length 40 - 60 characters'
        ])

        @formField('input', [
        'name' => 'metadata[description]',
        'label' => 'Meta Description',
        'type' => 'textarea',
        'rows' => 2,
        'note' => 'Recommended length 80 - 120 characters'
        ])

        <a17-inputframe>
        <details>
            <summary>
                <span class="f--note f--underlined">Advanced Settings</span> - <span class="f--small">Edit nofollow, noindex and canonical url</span>
            </summary>

            @formField('checkbox', [
            'name' => 'metadata[noindex]',
            'label' => 'Tell search engines not to index this page (noindex tag).',
            ])

            @formField('checkbox', [
            'name' => 'metadata[nofollow]',
            'label' => 'Tell search engines not to follow links on this page (nofollow tag).',
            ])

            @formField('input', [
            'name' => 'metadata[canonical_url]',
            'label' => 'Canonical URL',
            'note' => 'Only populate this field if the canonical url is different to the site url'
            ])
        </details>
        </a17-inputframe>

        <a17-inputframe>
        <details>
            <summary>
                <span class="f--note f--underlined">Social Sharing Settings</span> - <span class="f--small">Customise how your content appears when shared on social media</span>
            </summary>

            @formField('medias', [
            'name' => 'og_image',
            'label' => 'Social Image',
            'fieldNote' => 'Specify a custom image for Twitter and Facebook cards (recommended width 1200px)'
            ])

            @formField('input', [
            'name' => 'metadata[og_title]',
            'label' => 'Social Title',
            'note' => 'Provide a custom title (defaults to the meta title if blank)'
            ])

            @formField('input', [
            'name' => 'metadata[og_description]',
            'label' => 'Social Description',
            'type' => 'textarea',
            'rows' => 2,
            'note' => 'Provide a custom description (defaults to the meta description if blank)'
            ])

            <x-formColumns>
                <x-slot name="left">
                    @formField('select', [
                    'name' => 'metadata[card_type]',
                    'label' => 'Twitter Card Style',
                    'placeholder' => 'Select a style',
                    'options' => $metadata_card_type_options,
                    ])
                </x-slot>
                <x-slot name="right">
                    @formField('select', [
                    'name' => 'metadata[og_type]',
                    'label' => 'OpenGraph Type',
                    'placeholder' => 'Select a Type',
                    'options' => $metadata_og_type_options,
                    ])
                </x-slot>

            </x-formColumns>
        </details>
        </a17-inputframe>
    </x-formFieldset>

@endif
