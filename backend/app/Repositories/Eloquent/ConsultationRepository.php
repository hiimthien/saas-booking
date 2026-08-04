<?php

namespace App\Repositories\Eloquent;

use App\Models\Consultation;
use App\Repositories\Contracts\ConsultationRepositoryInterface;

class ConsultationRepository implements ConsultationRepositoryInterface
{
    public function create(array $data): Consultation
    {
        return Consultation::create($data);
    }
}
