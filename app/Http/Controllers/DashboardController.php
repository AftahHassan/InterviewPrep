<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $domains = Auth::user()->domains()
            ->withCount([
                'concepts',
                'concepts as mastered_count' => fn ($q) => $q->where('status', 'mastered'),
                'concepts as to_review_count' => fn ($q) => $q->where('status', 'to_review'),
                'concepts as in_progress_count' => fn ($q) => $q->where('status', 'in_progress'),
            ])
            ->get();

        return view('dashboard', [
            'domains' => $domains,
            'totalConcepts' => $domains->sum('concepts_count'),
            'masteredConcepts' => $domains->sum('mastered_count'),
            'toReviewConcepts' => $domains->sum('to_review_count'),
            'inProgressConcepts' => $domains->sum('in_progress_count'),
        ]);
    }
}
