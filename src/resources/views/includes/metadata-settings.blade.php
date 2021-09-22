@formField('input', [
    'name' => 'site_title',
    'label' => twillTrans('twill-metadata::settings.fields.site_title.label'),
    'note' => twillTrans('twill-metadata::settings.fields.site_title.note'),
    'textLimit' => '80',
    'translated' => true,
])

@formField('medias', [
    'name' => 'default_social_image',
    'label' => twillTrans('twill-metadata::settings.fields.og_image.label'),
    'translated' => true,
])

@formField('input', [
    'name' => 'site_twitter',
    'label' => twillTrans('twill-metadata::settings.fields.twitter_handle.label'),
    'note' => twillTrans('twill-metadata::settings.fields.twitter_handle.note'),
    'textLimit' => '80',
    'translated' => true,
])
