<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'consultant_tag');
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
