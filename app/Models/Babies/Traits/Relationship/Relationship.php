<?php namespace App\Models\Babies\Traits\Relationship;

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
        return $this->belongsTo(User::class, 'parent_id');
    }
}