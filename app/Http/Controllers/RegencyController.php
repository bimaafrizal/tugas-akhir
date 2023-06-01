<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function getRegency(Request $request)
    {
        $regencies = Regency::where('province_id', $request->id)->get();
        foreach ($regencies as $regency) {
            echo "<option value='$regency->id' {{ old('regency_id') == $regency->id ? 'selected' : '' }}> $regency->name</option>";
        }
    }
}