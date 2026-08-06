<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultantProfileResource;
use App\Services\ConsultantService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConsultantController extends Controller
{
    protected ConsultantService $consultantService;

    public function __construct(ConsultantService $consultantService)
    {
        $this->consultantService = $consultantService;
    }

    /**
     * Display a listing of active consultants.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->query('per_page', 15);
        $consultants = $this->consultantService->getActiveConsultants((int) $perPage);

        return ConsultantProfileResource::collection($consultants);
    }

    /**
     * Display the specified consultant by slug.
     */
    public function show(string $slug): ConsultantProfileResource
    {
        $consultant = $this->consultantService->getConsultantBySlug($slug);

        return new ConsultantProfileResource($consultant);
    }
}
