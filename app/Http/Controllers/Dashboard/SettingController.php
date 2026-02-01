<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request, Company $company)
    {
        return view('dashboard.settings.index', compact('company'));
    }
}
