<?php

namespace App\Services;

use App\Models\ConsultantProfile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ConsultantService
{
    /**
     * Get a paginated list of active consultants with filters.
     * Prevents N+1 query problem by eager loading.
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getActiveConsultants(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $page = request()->get('page', 1);
        $cacheKey = 'consultants.active.' . md5(json_encode(array_merge($filters, ['page' => $page, 'perPage' => $perPage])));
        
        $cached = Cache::get($cacheKey);
        if ($cached instanceof LengthAwarePaginator) {
            return $cached;
        }

        $query = ConsultantProfile::with(['user', 'tags'])->withAvg('reviews', 'rating')->where('is_active', true);

        // 1. Search by title or user name
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', '%' . $search . '%')
                  ->orWhereHas('user', function ($uQ) use ($search) {
                      $uQ->where('name', 'ilike', '%' . $search . '%');
                  });
            });
        }

        // 2. Filter by tags
        if (!empty($filters['tags'])) {
            $tags = explode(',', $filters['tags']);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tags.id', $tags);
            });
        }

        // 3. Filter by price range
        if (isset($filters['min_price'])) {
            $query->where('hourly_rate', '>=', $filters['min_price']);
        }
        if (isset($filters['max_price'])) {
            $query->where('hourly_rate', '<=', $filters['max_price']);
        }

        // 4. Filter by rating
        if (isset($filters['rating'])) {
            $query->having('reviews_avg_rating', '>=', $filters['rating']);
        }

        $paginator = $query->paginate($perPage);

        try {
            Cache::put($cacheKey, $paginator, 3600);
        } catch (\Throwable $e) {
            // Ignore cache failure if serialization fails
        }

        return $paginator;
    }

    /**
     * Get a specific consultant by slug.
     *
     * @param string $slug
     * @return ConsultantProfile
     */
    public function getConsultantBySlug(string $slug): ConsultantProfile
    {
        $cacheKey = 'consultant.profile.' . $slug;
        $cached = Cache::get($cacheKey);
        if ($cached instanceof ConsultantProfile) {
            return $cached;
        }

        $consultant = ConsultantProfile::with(['user', 'tags', 'workingHours', 'reviews.customer'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        try {
            Cache::put($cacheKey, $consultant, 3600);
        } catch (\Throwable $e) {
            // Ignore cache failure if serialization fails
        }

        return $consultant;
    }
}
