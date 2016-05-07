<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use MyModel, SoftDeletes;
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

    public function updateRoles(){
        $roles = request()->roles;
        if (count($roles) > 0) {
            $this->roles()->detach();
            foreach($roles as $role) {
                $this->assignById($role);
            }
        }
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    public function assign($role){
        return $this->roles()->save(
            is_string($role)?
            Role::whereName($role)->firstOrFail()
            :$role
        );
    }

    public function assignById($role){
        return $this->roles()->save(
            is_string($role)?
            Role::whereId($role)->firstOrFail()
            :$role
        );
    }

    public function hasHigherRolePriority($id) {
        $_user = $this->findOrFail($id);
        return 
            ($this->id === $_user->id)
            || (!$_user->rolePriority())
            || ($this->rolePriority() < $_user->rolePriority());
    }

    public function rolePriority() {
        $roles = objectsToArray($this->roles, 'priority');
        if(count($roles)){
            return min($roles);
        }
        return false;
    }

    /*
     * MyModel Trait
     */

    public static function listFields() {
        return [
            'id', 'name', 'email', 'roles' => 'name',
        ];
    }

    public static function toBeFilledFields(){
        return [
            'name' => 'text',
            'email' => 'text',
            'password' => 'password',
            'roles' => 'multiple',
        ];
    }
}
