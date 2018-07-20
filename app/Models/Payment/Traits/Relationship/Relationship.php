<?php namespace App\Models\Payment\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Booking\Booking;

trait Relationship
{
	/**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
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