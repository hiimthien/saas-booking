<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function consultantProfiles()
    {
        return $this->belongsToMany(ConsultantProfile::class, 'consultant_tag');
    }
}
