<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultantProfileResource;
use App\Models\ConsultantProfile;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the consultants.
     */
    public function index(Request $request)
    {
        $query = ConsultantProfile::with(['user', 'tags'])->where('is_active', true);

        if ($request->has('min_rate') && is_numeric($request->min_rate)) {
            $query->where('hourly_rate', '>=', $request->min_rate);
        }

        if ($request->has('max_rate') && is_numeric($request->max_rate)) {
            $query->where('hourly_rate', '<=', $request->max_rate);
        }

        if ($request->has('min_rating') && is_numeric($request->min_rating)) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Apply sorting
        $sort = $request->get('sort', 'recommended');
        if ($sort === 'price_asc') {
            $query->orderBy('hourly_rate', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('hourly_rate', 'desc');
        } elseif ($sort === 'highest_rated') {
            $query->orderBy('rating', 'desc');
        } else {
            // recommended: sort by reviews_count desc
            $query->orderBy('reviews_count', 'desc');
        }

        $consultants = $query->paginate(12);

        return ConsultantProfileResource::collection($consultants);
    }

    public function show($slug)
    {
        $consultant = ConsultantProfile::with(['user', 'tags', 'workingHours'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        return new ConsultantProfileResource($consultant);
    }
}
