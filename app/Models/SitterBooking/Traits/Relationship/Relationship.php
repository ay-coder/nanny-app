<?php namespace App\Models\SitterBooking\Traits\Relationship;
use App\Models\Access\User\User;
use App\Models\Reviews\Reviews;
use App\Models\Booking\Booking;

trait Relationship
{
	/**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'sitter_id', 'user_id');
    }

    /**
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitter_bookings()
    {
        return $this->hasMany(Booking::class, 'sitter_id', 'user_id');
    }

    /**
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitter_completed_bookings()
    {
        return $this->hasMany(Booking::class, 'sitter_id', 'user_id')->where('booking_status', 'COMPLETED');
    }
}