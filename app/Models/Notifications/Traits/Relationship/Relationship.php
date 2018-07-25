<?php namespace App\Models\Notifications\Traits\Relationship;

use App\Models\Access\User\User;

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
        return $this->belongsTo(User::class, 'sitter_id');
    }
}