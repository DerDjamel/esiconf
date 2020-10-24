<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function conferences(){
        return $this->hasMany('App\Conference');
    }

    public function reviewers(){
        return $this->hasMany('App\Reviewer');
    }

    public function papers(){
        return $this->belongsToMany('App\Paper', 'authors');
    }

    public function reviews()
    {
        return $this->hasManyThrough('App\Review', 'App\Reviewer');
    }

    public function bids()
    {
        return $this->hasManyThrough('App\Bid', 'App\Reviewer');
    }

    public function assigned_papers()
    {
        return $this->reviewers->pluck('paper_id');
    }
}
