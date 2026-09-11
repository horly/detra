<?php

test('renders each public page in its requested language', function (string $path, string $locale, string $heading, string $alternate) {
    $response = $this->get($path);

    $response->assertSeeText($heading)
        ->assertSee('lang="'.$locale.'"', false)
        ->assertHeader('Content-Language', $locale)
        ->assertSee('href="'.url($alternate).'"', false)
        ->assertDontSee('site.meta.');
})->with([
    'French home' => ['/fr', 'fr', 'L’énergie qui', '/en'],
    'English home' => ['/en', 'en', 'The energy', '/fr'],
    'French about' => ['/fr/a-propos', 'fr', 'Ancrés à Kinshasa.', '/en/about'],
    'English about' => ['/en/about', 'en', 'Rooted in Kinshasa.', '/fr/a-propos'],
    'French services' => ['/fr/services', 'fr', 'Une chaîne de solutions.', '/en/services'],
    'English services' => ['/en/services', 'en', 'Connected solutions.', '/fr/services'],
    'French products' => ['/fr/produits', 'fr', 'À chaque activité,', '/en/products'],
    'English products' => ['/en/products', 'en', 'Every business.', '/fr/produits'],
    'French commitments' => ['/fr/engagements', 'fr', 'La confiance se construit.', '/en/commitments'],
    'English commitments' => ['/en/commitments', 'en', 'Trust is built.', '/fr/engagements'],
    'French contact' => ['/fr/contact', 'fr', 'Votre prochain projet', '/en/contact'],
    'English contact' => ['/en/contact', 'en', 'Your next project', '/fr/contact'],
    'French privacy' => ['/fr/confidentialite', 'fr', 'vos données.', '/en/privacy'],
    'English privacy' => ['/en/privacy', 'en', 'your data.', '/fr/confidentialite'],
]);

test('returns a branded 404 for unsupported languages and unknown pages', function (string $path, string $message) {
    $response = $this->get($path);

    $response->assertNotFound()->assertSeeText($message);
})->with([
    ['/de', 'Cette page a changé d’horizon.'],
    ['/fr/inconnu', 'Cette page a changé d’horizon.'],
    ['/en/unknown', 'This page has sailed away.'],
]);

test('prefills a product enquiry with the selected product and supply service', function () {
    $response = $this->get('/fr/contact?service=supply&product=diesel');

    $response->assertSee('value="supply" selected', false)->assertSeeText('Gasoil —');
});

test('renders only configured contact details', function () {
    config()->set('site.email', 'office@example.test');
    config()->set('site.phone', '+243 000 000 000');
    config()->set('site.address', 'Adresse de test à Kinshasa');

    $response = $this->get('/fr/contact');

    $response->assertSee('mailto:office@example.test', false)
        ->assertSee('tel:+243000000000', false)
        ->assertSeeText('Adresse de test à Kinshasa');
});

test('escapes old form inputs when displaying validation feedback', function () {
    $unsafe = '<script>alert("test")</script>';
    $this->withSession(['_old_input' => array_fill_keys(['name', 'company', 'email', 'phone', 'message'], $unsafe)]);

    $response = $this->get('/fr/contact');

    $response->assertSee($unsafe)->assertDontSee($unsafe, false);
});

test('shows the enquiry reference in a localized confirmation', function () {
    $this->withSession(['inquiry_reference' => 'DTR-000123']);

    $response = $this->get('/en/contact');

    $response->assertSeeText('Your enquiry has been saved.')
        ->assertSeeText('DTR-000123')->assertDontSee('data-inquiry-form', false);
});

test('offers an enquiry form directly on each localized home page', function (string $locale, string $button) {
    $response = $this->get('/'.$locale);

    $response->assertSee('id="contact"', false)
        ->assertSee('action="'.url('/'.$locale).'"', false)
        ->assertSee('href="#contact"', false)
        ->assertSeeText($button);
})->with([
    ['fr', 'Envoyer ma demande'],
    ['en', 'Send my enquiry'],
]);

test('keeps the confirmation and new enquiry link on the home page', function (string $locale) {
    $this->withSession(['inquiry_reference' => 'DTR-000456']);

    $response = $this->get('/'.$locale);

    $response->assertSeeText('DTR-000456')
        ->assertSee('href="'.url('/'.$locale).'#contact"', false)
        ->assertDontSee('data-inquiry-form', false);
})->with(['fr', 'en']);
