<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $inquiry = Inquiry::create([
            ...$request->safe()->only(['name', 'company', 'email', 'phone', 'service', 'message']),
            'locale' => app()->getLocale(),
            'consented_at' => now(),
        ]);

        $page = $request->route('page', 'contact');
        $destination = route(app()->getLocale().'.'.$page).($page === 'home' ? '#contact' : '');

        return redirect($destination)
            ->with('inquiry_reference', sprintf('DTR-%06d', $inquiry->id));
    }
}
