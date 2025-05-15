<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'guest_count',
        'reservation_datetime',
        'service_type',
        'special_requests',
        'status',
        'admin_notes', // Tambahkan ini
    ];

    protected $casts = [
        'reservation_datetime' => 'datetime',
        'guest_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceTypeLabelAttribute()
    {
        return match($this->service_type) {
            'dinner' => 'Dinner Reservation',
            'lunch' => 'Lunch Reservation',
            'meeting' => 'Business Meeting',
            'wedding' => 'Wedding Event',
            'other' => 'Other Event',
            default => ucfirst($this->service_type),
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'completed' => 'blue',
            default => 'gray',
        };
    }
}