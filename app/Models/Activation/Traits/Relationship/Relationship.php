<?php namespace App\Models\Activation\Traits\Relationship;

use App\Models\Plans\Plans;
use App\Models\Access\User\User;

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

    /** Belongs to relations with Plans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}