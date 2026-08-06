<?php

namespace App\Services;

use App\Models\ConsultantProfile;
use Illuminate\Pagination\LengthAwarePaginator;

class ConsultantService
{
    /**
     * Get a paginated list of active consultants with their relationships.
     * Prevents N+1 query problem by eager loading.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getActiveConsultants(int $perPage = 15): LengthAwarePaginator
    {
        return ConsultantProfile::with(['user', 'tags'])
            ->where('is_active', true)
            ->paginate($perPage);
    }

    /**
     * Get a specific consultant by slug.
     *
     * @param string $slug
     * @return ConsultantProfile
     */
    public function getConsultantBySlug(string $slug): ConsultantProfile
    {
        return ConsultantProfile::with(['user', 'tags', 'workingHours', 'reviews.customer'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }
}
