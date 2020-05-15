@if( $item->hasMetadata )
    <x-formFieldset title="SEO Details" id="metadata">
        @formField('input', [
        'name' => 'metadata[title]',
        'label' => 'SEO Title',
        'note' => 'defaults to the page title if blank'
        ])

        @formField('input', [
        'name' => 'metadata[description]',
        'label' => 'SEO Description',
        'note' => 'defaults to an excerpt of the page content if blank'
        ])

        @formField('input', [
        'name' => 'metadata[og_title]',
        'label' => 'Social Title',
        'note' => 'defaults to the seo title if blank'
        ])

        @formField('input', [
        'name' => 'metadata[og_description]',
        'label' => 'Social Description',
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



    </x-formFieldset>

@endif
