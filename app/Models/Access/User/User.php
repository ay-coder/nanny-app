<?php

namespace App\Models\Access\User;

use Illuminate\Notifications\Notifiable;
use App\Models\Access\User\Traits\UserAccess;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Access\User\Traits\Scope\UserScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Access\User\Traits\UserSendPasswordReset;
use App\Models\Access\User\Traits\Attribute\UserAttribute;
use App\Models\Access\User\Traits\Relationship\UserRelationship;
use Carbon\Carbon;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use UserScope,
        UserAccess,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserRelationship,
        UserSendPasswordReset;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'status',
        'confirmation_code',
        'confirmed',
        'profile_pic',
        'device_token',
        'device_type',
        'user_type',
        'gender',
        'birthdate',
        'address',
        'city',
        'state',
        'zip',
        'lat',
        'long',
        'social_provider',
        'social_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.users_table');
    }

    /**
     * Get Full Name
     *
     * @param $user
     * @return string
     */
    public function getFullName($user = flase)
    {
        $user = $user ? $user : $this;
        return $user->first_name . ' ' . $user->last_name;
    }

    /**
     * Accessor for Age.
     */
    public function getAgeAttribute()
    {
        if(!empty($this->attributes['birthdate']))
        {
            return Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->attributes['birthdate'])->format('d-m-Y'))->age;
        }
        return '';
    }
}
