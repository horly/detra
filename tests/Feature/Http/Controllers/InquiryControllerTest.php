<?php

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function validInquiryPayload(array $overrides = []): array
{
    return array_replace([
        'name' => 'Marie Test',
        'company' => 'Entreprise de test',
        'email' => 'marie@example.test',
        'phone' => '+243 000 000 000',
        'service' => 'import',
        'message' => 'Nous souhaitons étudier un approvisionnement en gasoil à Kinshasa.',
        'consent' => '1',
    ], $overrides);
}

test('saves an enquiry with the route language and server consent time', function (string $locale) {
    $this->travelTo('2026-09-10 10:00:00');
    $payload = validInquiryPayload(['locale' => 'de', 'consented_at' => '2000-01-01', 'id' => 9999]);

    $response = $this->post('/'.$locale.'/contact', $payload);

    $response->assertRedirectToRoute($locale.'.contact')->assertSessionHasNoErrors()
        ->assertSessionHas('inquiry_reference', 'DTR-000001');
    $this->assertDatabaseCount(Inquiry::class, 1);
    $this->assertDatabaseHas(Inquiry::class, [
        'id' => 1, 'name' => 'Marie Test', 'company' => 'Entreprise de test',
        'email' => 'marie@example.test', 'phone' => '+243 000 000 000',
        'service' => 'import', 'message' => $payload['message'],
        'locale' => $locale, 'consented_at' => '2026-09-10 10:00:00',
    ]);
})->with(['fr', 'en']);

test('accepts the supported service choices without optional contact fields', function (string $service) {
    $payload = validInquiryPayload(['service' => $service, 'phone' => null, 'company' => null]);

    $response = $this->post('/fr/contact', $payload);

    $response->assertSessionHasNoErrors()->assertRedirectToRoute('fr.contact');
    $this->assertDatabaseHas(Inquiry::class, ['service' => $service, 'phone' => null, 'company' => null]);
})->with(['export', 'logistics', 'supply', 'other']);

test('rejects missing required fields with French feedback and saves nothing', function () {
    $response = $this->from('/fr/contact')->post('/fr/contact', []);

    $response->assertRedirect('/fr/contact')->assertSessionHasErrors([
        'name' => 'Le champ nom complet est obligatoire.',
        'email' => 'Le champ adresse e-mail est obligatoire.',
        'service' => 'Le champ service est obligatoire.',
        'message' => 'Le champ message est obligatoire.',
        'consent' => 'Le champ consentement doit être accepté.',
    ]);
    $this->assertDatabaseEmpty(Inquiry::class);
});

test('rejects invalid enquiry fields with precise feedback and saves nothing', function (string $field, mixed $value, string $error) {
    $payload = validInquiryPayload([$field => $value]);

    $response = $this->from('/fr/contact')->post('/fr/contact', $payload);

    $response->assertRedirect('/fr/contact')->assertSessionHasErrors([$field => $error]);
    $this->assertDatabaseEmpty(Inquiry::class);
})->with([
    'malformed email' => ['email', 'not-an-email', 'Le champ adresse e-mail doit être une adresse e-mail valide.'],
    'unknown service' => ['service', 'invalid', 'Le champ service sélectionné est invalide.'],
    'short message' => ['message', 'Bonjour', 'Le champ message doit contenir au moins 20 caractères.'],
    'long message' => ['message', str_repeat('a', 5001), 'Le champ message ne doit pas dépasser 5000 caractères.'],
    'long name' => ['name', str_repeat('a', 121), 'Le champ nom complet ne doit pas dépasser 120 caractères.'],
    'long company' => ['company', str_repeat('a', 161), 'Le champ entreprise ne doit pas dépasser 160 caractères.'],
    'long email' => ['email', str_repeat('a', 245).'@example.test', 'Le champ adresse e-mail ne doit pas dépasser 254 caractères.'],
    'long phone' => ['phone', str_repeat('1', 41), 'Le champ téléphone ne doit pas dépasser 40 caractères.'],
    'no consent' => ['consent', '0', 'Le champ consentement doit être accepté.'],
    'bot field filled' => ['website', 'https://example.test', 'Le champ champ de vérification doit rester vide.'],
    'non-text name' => ['name', ['test'], 'Le champ nom complet doit être du texte.'],
    'non-text company' => ['company', ['test'], 'Le champ entreprise doit être du texte.'],
    'non-text phone' => ['phone', ['test'], 'Le champ téléphone doit être du texte.'],
    'non-text message' => ['message', ['test'], 'Le champ message doit être du texte.'],
]);

test('returns English validation feedback on the English form', function () {
    $response = $this->from('/en/contact')->post('/en/contact', validInquiryPayload(['email' => 'invalid']));

    $response->assertSessionHasErrors(['email' => 'The email address field must be a valid email address.']);
    $this->assertDatabaseEmpty(Inquiry::class);
});

test('limits repeated submissions across languages without saving a blocked enquiry', function () {
    $this->freezeTime();
    for ($attempt = 0; $attempt < 5; $attempt++) {
        $this->post('/fr/contact', []);
    }

    $response = $this->post('/en/contact', validInquiryPayload());

    $response->assertTooManyRequests()->assertSeeText('Just a moment, please.')
        ->assertHeader('Retry-After');
    $this->assertDatabaseEmpty(Inquiry::class);
});

test('does not expose saved enquiries on a public route', function () {
    $response = $this->get('/fr/inquiries');

    $response->assertNotFound();
});

test('saves a home page enquiry and returns to its contact section', function (string $locale) {
    $payload = validInquiryPayload(['page' => 'contact', 'return_to' => 'https://example.test']);

    $response = $this->post('/'.$locale, $payload);

    $response->assertRedirect(url('/'.$locale).'#contact')->assertSessionHasNoErrors()
        ->assertSessionHas('inquiry_reference', 'DTR-000001');
    $this->assertDatabaseCount(Inquiry::class, 1);
    $this->assertDatabaseHas(Inquiry::class, [
        'email' => 'marie@example.test', 'message' => $payload['message'], 'locale' => $locale,
    ]);
})->with(['fr', 'en']);

test('returns home page validation errors to the form with the input preserved', function (string $locale) {
    $payload = validInquiryPayload(['email' => 'invalid']);

    $response = $this->from('/'.$locale)->post('/'.$locale, $payload);

    $response->assertRedirect(url('/'.$locale).'#contact')->assertSessionHasErrors('email')
        ->assertSessionHasInput('name', 'Marie Test');
    $this->assertDatabaseEmpty(Inquiry::class);
})->with(['fr', 'en']);

test('applies the shared submission limit to the home form and links back to it', function () {
    $this->freezeTime();
    for ($attempt = 0; $attempt < 5; $attempt++) {
        $this->post('/fr/contact', []);
    }

    $response = $this->post('/en', validInquiryPayload());

    $response->assertTooManyRequests()->assertSeeText('Just a moment, please.')
        ->assertSee('href="'.url('/en').'#contact"', false);
    $this->assertDatabaseEmpty(Inquiry::class);
});
