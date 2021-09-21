@if( $item->hasMetadata )
    <x-formFieldset title="SEO Details" id="metadata">
        @formField('input', [
        'name' => 'metadata[title]',
        'translated' => true,
        'label' => 'SEO Title',
        'note' => 'defaults to the page title if blank'
        ])

        @formField('input', [
        'name' => 'metadata[description]',
        'label' => 'SEO Description',
        'translated' => true,
        'note' => 'defaults to an excerpt of the page content if blank'
        ])

        @formField('input', [
        'name' => 'metadata[og_title]',
        'label' => 'Social Title',
        'translated' => true,
        'note' => 'defaults to the seo title if blank'
        ])

        @formField('input', [
        'name' => 'metadata[og_description]',
        'label' => 'Social Description',
        'translated' => true,
        'note' => 'defaults to the seo description if blank'
        ])

        @formField('medias', [
        'name' => 'og_image',
        'label' => 'Social Image',
        'fieldNote' => 'Minimum image width: 1200px'
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


        @formField('checkbox', [
        'name' => 'metadata[noindex]',
        'label' => 'Tell search engines not to index this page (noindex).',
        ])

        @formField('checkbox', [
        'name' => 'metadata[nofollow]',
        'label' => 'Tell search engines not to follow links on this page (nofollow).',
        ])


        @formField('input', [
        'name' => 'metadata[canonical_url]',
        'label' => 'Canonical URL',
        'translated' => true,
        ])


    </x-formFieldset>

@endif
