@formField('input', [
'label' => 'Site title',
'name' => 'site_title',
'note' => 'This will be appended after the page title, unless a custom meta title is defined.',
'textLimit' => '80'
])

@formField('medias', [
'name' => 'default_social_image',
'label' => 'Default Social Image',
])

@formField('input', [
'label' => 'Site Twitter Handle',
'name' => 'site_twitter',
'note' => 'If the organization has a twitter account, add it here. Include the @symbol. e.g @CWS_Digital',
'textLimit' => '80'
])
