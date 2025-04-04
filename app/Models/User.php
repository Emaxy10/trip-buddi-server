<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function roles()
    {
       return $this->belongsToMany(Role::class, 'user_role');
    }

      //Assign user role
    // Accepts a role ID, role name, or Role model instance

    public function assignRole($role){
        if(is_string($role)){
            $role = Role::where('name', $role)->firstOrFail();
        }
        elseif(is_numeric($role)){
            $role = Role::where('name', $role)->firstOrFail();
         }
         return $this->roles()->attach($role);
    }
    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        
        if(is_numeric($role)){
            return $this->roles->contains('name', $role);
        }
    }

}
