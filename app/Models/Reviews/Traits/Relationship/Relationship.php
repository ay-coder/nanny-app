<?php namespace App\Models\Reviews\Traits\Relationship;

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
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
