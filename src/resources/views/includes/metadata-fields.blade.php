@if( $item->hasMetadata )
    <x-formFieldset title="{{ twillTrans('twill-metadata::form.titles.fieldset') }}" id="metadata">
        @formField('input', [
            'name' => 'metadata[title]',
            'label' =>  twillTrans('twill-metadata::form.fields.title.label'),
            'note' => twillTrans('twill-metadata::form.fields.title.note'),
            'translated' => true,
        ])

        @formField('input', [
            'name' => 'metadata[description]',
            'label' => twillTrans('twill-metadata::form.fields.description.label'),
            'note' => twillTrans('twill-metadata::form.fields.description.note'),
            'type' => 'textarea',
            'rows' => 2,
            'translated' => true,
        ])

        <a17-inputframe>
            <details>
                <summary>
                    <span class="f--note f--underlined">{{ twillTrans('twill-metadata::form.titles.advanced_settings') }}</span> - <span class="f--small">{{ twillTrans('twill-metadata::form.titles.advanced_description') }}</span>
                </summary>

                @formField('checkbox', [
                    'name' => 'metadata[noindex]',
                    'label' => twillTrans('twill-metadata::form.fields.noindex.label'),
                ])

                @formField('checkbox', [
                'name' => 'metadata[nofollow]',
                'label' => twillTrans('twill-metadata::form.fields.nofollow.label'),
                ])

                @formField('input', [
                'name' => 'metadata[canonical_url]',
                'label' => twillTrans('twill-metadata::form.fields.canonical_url.label'),
                'translated' => true,
                'note' => twillTrans('twill-metadata::form.fields.canonical_url.note'),
                ])
            </details>
        </a17-inputframe>

        <a17-inputframe>
            <details>
                <summary>
                    <span class="f--note f--underlined">{{twillTrans('twill-metadata::form.titles.sharing_settings')}}</span> - <span class="f--small">{{twillTrans('twill-metadata::form.titles.sharing_description')}}</span>
                </summary>

                @formField('medias', [
                    'name' => 'og_image',
                    'label' => twillTrans('twill-metadata::form.fields.og_image.label'),
                    'fieldNote' => twillTrans('twill-metadata::form.fields.og_image.note'),
                ])

                @formField('input', [
                    'name' => 'metadata[og_title]',
                    'label' => twillTrans('twill-metadata::form.fields.og_title.label'),
                    'note' => twillTrans('twill-metadata::form.fields.og_title.note'),
                ])

                @formField('input', [
                    'name' => 'metadata[og_description]',
                    'label' => twillTrans('twill-metadata::form.fields.og_description.label'),
                    'type' => 'textarea',
                    'rows' => 2,
                    'note' => twillTrans('twill-metadata::form.fields.og_description.note'),
                ])

                <x-formColumns>
                    <x-slot name="left">
                        @formField('select', [
                            'name' => 'metadata[card_type]',
                            'label' => twillTrans('twill-metadata::form.fields.og_card_type.label'),
                            'placeholder' => twillTrans('twill-metadata::form.fields.og_card_type.placeholder'),
                            'options' => $metadata_card_type_options,
                        ])
                    </x-slot>
                    <x-slot name="right">
                        @formField('select', [
                            'name' => 'metadata[og_type]',
                            'label' => twillTrans('twill-metadata::form.fields.og_type.label'),
                            'placeholder' => twillTrans('twill-metadata::form.fields.og_type.placeholder'),
                            'options' => $metadata_og_type_options,
                        ])
                    </x-slot>
                </x-formColumns>
            </details>
        </a17-inputframe>
    </x-formFieldset>
@endif
