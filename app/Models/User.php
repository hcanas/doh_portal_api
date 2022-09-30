<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'biometrics_id',
        'avatar',
        'code',
        'name',
        'nickname',
        'address',
        'contact_number',
        'email',
        'position',
        'birthdate',
        'sex',
        'blood_type',
        'gsis_number',
        'pagibig_number',
        'philhealth_number',
        'tin_number',
        'emergency_contact_name',
        'emergency_contact_number',
        'contract_from',
        'contract_to',
        'username',
        'password',
    ];
    
    protected $hidden = [
        'password',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'credentials');
    }
    
    public function offices()
    {
        return $this->belongsToMany(Office::class, 'credentials');
    }
    
    public function credentials()
    {
        return $this->hasMany(Credential::class)
            ->with('permission')
            ->with('office');
    }
}
