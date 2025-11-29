<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'specialty',
        'weekly_schedule',
        'active',
        'user_id'
    ];

    protected $casts = [
        'weekly_schedule' => 'array',
        'active' => 'boolean',
    ];

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            if (empty($doctor->slug)) {
                $doctor->slug = Str::slug($doctor->name);
            }
        });
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
