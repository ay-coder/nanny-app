<?php namespace App\Models\Booking\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Babies\Babies;
use App\Models\Payment\Payment;
use App\Models\Reviews\Reviews;

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
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    /**
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function baby()
    {
        return $this->belongsTo(Babies::class, 'baby_id');
    }

    /**
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    /**
     * Belongs to relations with Sitter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function review()
    {
        return $this->hasOne(Reviews::class, 'booking_id');
    }
}