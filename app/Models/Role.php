<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function users(){
        
        return $this->belongsToMany(User::class, 'user_role');
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }

    //check if role has permission
   public function hasPermission($permission){
        if(is_numeric($permission)){
            return $this->permissions->contains('name', $permission);
         }
        
         if(is_string($permission)){
            return $this->permissions->contains('name', $permission);
         }
    }
}
