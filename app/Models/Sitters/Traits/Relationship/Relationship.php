<?php namespace App\Models\Sitters\Traits\Relationship;

use App\Models\Access\User\User;
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
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'sitter_id', 'user_id');
    }

}