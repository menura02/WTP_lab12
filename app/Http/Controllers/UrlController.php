<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function shorten(Request $request)
    {
        // 1. Validasyon
        $request->validate([
            'original_url' => ['required', 'regex:/^https?:\/\/[^\s$.?#].[^\s]*$/i']
        ]);

        // 2. Daha önce kayıtlı mı?
        $existing = Url::where('original_url', $request->original_url)->first();
        if ($existing) {
            return view('home', ['short' => url($existing->short_code)]);
        }

        // 3. Yeni kayıt oluştur
        do {
            $short = $this->generateShortCode();
        } while (Url::where('short_code', $short)->exists());

        Url::create([
            'original_url' => $request->original_url,
            'short_code' => $short,
        ]);

        return view('home', ['short' => url($short)]);
    }

    public function redirect($code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();
        return redirect()->away($url->original_url);
    }

    private function generateShortCode(): string
    {
        return substr(str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(9))), 0, 12);
    }
}
