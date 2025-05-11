<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $guard_name = 'web';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        $personalDetail = $this->personalDetails()->where('status', 1)->first();
        return $personalDetail->first_name . ' ' . $personalDetail->middle . ' ' . $personalDetail->last_name;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Employee::class);
    }

    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_media_id');
    }

    public function personalDetails()
    {
        return $this->morphMany(PersonalDetails::class, 'userable');
    }

    public function getPersonalDetail(): PersonalDetails
    {
        $personalDetail = $this->personalDetails()->where('status', 1)->first();
        return $personalDetail ?: new PersonalDetails;
    }

    public function getPermissionsArray(){
       return $this->getAllPermissions()->pluck('name')->toArray();
    }
}
