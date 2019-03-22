<?php namespace App\Models\Parents\Traits\Relationship;

use App\Models\Babies\Babies;

trait Relationship
{
	/**
     * Belongs to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function babies()
    {
        return $this->hasMany(Babies::class, 'parent_id');
    }
}