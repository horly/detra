@props(['source' => 'contact'])
@php
    $locale = app()->getLocale();
    $returnUrl = route($locale.'.'.$source).($source === 'home' ? '#contact' : '');
@endphp
<section id="contact" {{ $attributes->class(['section-space', 'contact-section', 'home-contact' => $source === 'home']) }} aria-labelledby="contact-heading"><div class="site-container">
    <div class="contact-intro grid items-end gap-7 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20" data-reveal>
        <div>
            <p class="eyebrow">{{ __('contact.eyebrow') }}</p>
        @if($source === 'home')
            <h2 id="contact-heading">{{ __('site.cta.title') }}<br><span class="text-copper">{{ __('site.cta.accent') }}</span></h2>
        @else
            <h2 id="contact-heading">{{ __('site.contact.heading') }}</h2>
        @endif
        </div>
        <div class="contact-intro-copy"><p class="body-copy">{{ __('contact.intro') }}</p><p class="contact-language-note"><span>FR / EN</span>{{ __('contact.languages') }}</p></div>
    </div>
    <div class="contact-workspace grid lg:grid-cols-[0.82fr_1.18fr]">
    <div class="contact-form-panel" id="inquiry-form" data-reveal>
        @if(session('inquiry_reference'))
            <div class="success-panel" role="status" tabindex="-1" data-form-status><span class="success-icon"><x-icon name="check" /></span><h2>{{ __('site.contact.success_title') }}</h2><p>{{ __('site.contact.success_text', ['reference' => session('inquiry_reference')]) }}</p><a href="{{ $returnUrl }}" class="button button-dark">{{ __('site.contact.new_inquiry') }}<x-icon /></a></div>
        @else
            <div class="contact-form-heading"><div><p class="eyebrow">{{ __('contact.form_label') }}</p><h3>{{ __('site.contact.form_title') }}</h3><p>{{ __('contact.form_intro') }}</p></div><span><x-icon name="message" /></span></div>
            <p class="contact-required">{{ __('site.contact.required') }}</p>
            @if($errors->any())<div class="form-errors" role="alert" tabindex="-1" data-form-status><strong>{{ __('site.form.errors') }}</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ route($locale.($source === 'home' ? '.home.inquiries.store' : '.inquiries.store')) }}" method="POST" class="inquiry-form" data-inquiry-form>
                @csrf
                <fieldset class="contact-fieldset"><legend><span>01</span>{{ __('contact.coordinates') }}</legend>
                    <div class="grid gap-x-5 gap-y-5 sm:grid-cols-2">
                        <x-contact-field name="name" type="text" autocomplete="name" maxlength="120" icon="user" required />
                        <x-contact-field name="company" type="text" autocomplete="organization" maxlength="160" icon="building" />
                        <x-contact-field name="email" type="email" autocomplete="email" maxlength="254" icon="mail" required />
                        <x-contact-field name="phone" type="tel" autocomplete="tel" maxlength="40" icon="phone" />
                    </div>
                </fieldset>
                <fieldset class="contact-fieldset"><legend><span>02</span>{{ __('contact.project') }}</legend>
                <div class="form-field"><label for="service">{{ __('site.form.service') }} <span>*</span></label><div class="input-with-icon"><x-icon name="globe" /><select id="service" name="service" required @if($errors->has('service')) aria-invalid="true" aria-describedby="service-error" @endif><option value="">{{ __('site.form.choose') }}</option>@foreach(__('site.form.services') as $value => $label)<option value="{{ $value }}" @selected(old('service', request('service')) === $value)>{{ $label }}</option>@endforeach</select></div>@error('service')<p class="field-error" id="service-error">{{ $message }}</p>@enderror</div>
                @php
                    $selectedProduct = collect(__('site.products.items'))->firstWhere('id', request('product'));
                    $initialMessage = $selectedProduct ? $selectedProduct['title'].' — ' : '';
                @endphp
                <div class="form-field contact-message-field"><label for="message">{{ __('site.form.message') }} <span>*</span></label><textarea id="message" name="message" rows="4" minlength="20" maxlength="5000" required placeholder="{{ __('site.form.message_placeholder') }}" aria-describedby="message-hint{{ $errors->has('message') ? ' message-error' : '' }}" @if($errors->has('message')) aria-invalid="true" @endif>{{ old('message', $initialMessage) }}</textarea><div class="message-help"><span id="message-hint">{{ __('contact.minimum') }}</span><span data-message-count aria-label="{{ __('contact.message_count') }}" hidden></span></div>@error('message')<p class="field-error" id="message-error">{{ $message }}</p>@enderror</div>
                </fieldset>
                <div class="honeypot" aria-hidden="true"><label for="website">Website</label><input type="text" id="website" name="website" tabindex="-1" autocomplete="off"></div>
                <div><label class="consent-label"><input type="checkbox" name="consent" value="1" required @checked(old('consent')) @if($errors->has('consent')) aria-invalid="true" aria-describedby="consent-error" @endif><span>{{ __('site.form.consent') }} <a href="{{ route($locale.'.privacy') }}">{{ __('site.form.privacy_link') }}</a></span></label>@error('consent')<p class="field-error" id="consent-error">{{ $message }}</p>@enderror</div>
                <button type="submit" class="button button-copper contact-submit w-full" data-submit-label="{{ __('site.form.submit') }}" data-sending-label="{{ __('site.form.sending') }}"><span>{{ __('site.form.submit') }}</span><x-icon name="diagonal" /></button><p class="contact-form-note"><x-icon name="shield" />{{ __('site.contact.form_note') }}</p>
            </form>
        @endif
    </div>
    <x-contact-advisor />
    </div>
    <x-contact-map />
</div></section>
