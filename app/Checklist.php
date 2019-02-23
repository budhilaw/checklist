<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Checklist extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'object_id';

    protected $fillable = [
        'object_domain', 'description', 'urgency', 'is_completed', 'due', 'completed_at', 'last_update_by', 'updated_at'
    ];

    public function items()
    {
        return $this->hasMany('App\Item', 'id', 'object_id');
    }
}
