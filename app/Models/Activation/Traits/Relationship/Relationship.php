<?php namespace App\Models\Activation\Traits\Relationship;

use App\Models\Plans\Plans;

trait Relationship
{
	/**
     * Belongs to relations with Plans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id');
    }
}