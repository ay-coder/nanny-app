<?php namespace App\Models\Event\Traits\Relationship;

use App\Models\Access\User\User;

trait Relationship
{
	/**
	 * Relationship Mapping for Account
	 * @return mixed
	 */
	public function user()
	{
	    return $this->belongsTo(User::class, 'user_id');
	}
}