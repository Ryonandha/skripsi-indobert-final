<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function publicIndex()
    {
        $educations = Education::where('is_published', true)->latest()->paginate(12);
        return view('education.index', compact('educations'));
    }

    public function show(Education $education)
    {
        abort_unless($education->is_published, 404);
        return view('education.show', compact('education'));
    }
}