<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', PageController::class)
    ->middleware(SetLocale::class)
    ->defaults('locale', 'fr')->defaults('page', 'home')->name('home');

foreach (config('site.pages') as $locale => $pages) {
    Route::prefix($locale)->name($locale.'.')->middleware(SetLocale::class)->group(function () use ($locale, $pages) {
        foreach ($pages as $page => $slug) {
            Route::get($slug, PageController::class)
                ->defaults('locale', $locale)->defaults('page', $page)->name($page);
        }

        Route::post('/', [InquiryController::class, 'store'])
            ->defaults('locale', $locale)->defaults('page', 'home')
            ->middleware('throttle:inquiries')->name('home.inquiries.store');

        Route::post('contact', [InquiryController::class, 'store'])
            ->defaults('locale', $locale)->middleware('throttle:inquiries')->name('inquiries.store');
    });
}
