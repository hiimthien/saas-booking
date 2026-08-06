<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
        ];
    }

    public function consultantProfile()
    {
        return $this->belongsTo(ConsultantProfile::class);
    }
}
