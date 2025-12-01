<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'slug',
        'patient_name',
        'patient_email',
        'patient_phone',
        'start',
        'end',
        'status'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected $appends = ['start_formatted', 'end_formatted'];

    public function getStartFormattedAttribute()
    {
        return $this->start ? $this->start->format('Y-m-d H:i:s') : null;
    }

    public function getEndFormattedAttribute()
    {
        return $this->end ? $this->end->format('Y-m-d H:i:s') : null;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->slug)) {
                $appointment->slug = Str::uuid();
            }
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
