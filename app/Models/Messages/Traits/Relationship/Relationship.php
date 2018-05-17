<?php namespace App\Models\Messages\Traits\Relationship;

use App\Models\Access\User\User;

trait Relationship
{
	/**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
