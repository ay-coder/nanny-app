<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Event\Event;
use App\Models\System\Session;
use App\Models\Access\User\SocialLogin;
use App\Models\Babies\Babies;
use App\Models\Sitters\Sitters;
use App\Models\Booking\Booking;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.role_user_table'), 'user_id', 'role_id');
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return mixed
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return mixed
     */
    public function babies()
    {
        return $this->hasMany(Babies::class, 'parent_id');
    }    

    /**
     * @return mixed
     */
    public function sitter()
    {
        return $this->hasOne(Sitters::class, 'user_id');
    }
        
    /**
     * @return mixed
     */
    public function parent_bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    } 
}
