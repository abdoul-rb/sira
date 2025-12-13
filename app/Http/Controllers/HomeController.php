<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke()
    {
        $faqs = Cache::remember('faqs', 60 * 60, function () {
            $path = resource_path('data/faqs.json');
            $faqs = json_decode(file_get_contents($path), true);

            return $faqs;
        });

        return view('welcome', [
            'faqs' => $faqs,
        ]);
    }
}
