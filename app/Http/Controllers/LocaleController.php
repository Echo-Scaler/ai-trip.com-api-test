<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Set the application language format.
     */
    public function setLanguage($locale)
    {
        $supported = ['en', 'es', 'ja'];

        if (in_array($locale, $supported)) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }

    /**
     * Set the application currency format.
     */
    public function setCurrency($currency)
    {
        $supported = ['USD', 'EUR', 'JPY'];

        if (in_array($currency, $supported)) {
            session(['currency' => $currency]);
        }

        return redirect()->back();
    }
}
