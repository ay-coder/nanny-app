<?php namespace App\Models\BlockTimes\Traits\Relationship;

use App\Models\Access\User\User;

trait Relationship
{
	/**
     * @return mixed
     */
    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }
}