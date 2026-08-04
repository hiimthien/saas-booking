<?php

namespace App\Repositories\Contracts;

use App\Models\Consultation;

interface ConsultationRepositoryInterface
{
    /**
     * Create a new consultation record.
     *
     * @param array $data
     * @return Consultation
     */
    public function create(array $data): Consultation;
}
