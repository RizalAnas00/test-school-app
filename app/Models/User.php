<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
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
        'two_factor_secret',
        'two_factor_recovery_codes',
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

    // /**
    //  * Get the user's initials
    //  */
    // public function initials(): string
    // {
    //     return Str::of($this->username)
    //         ->explode(' ')
    //         ->take(2)
    //         ->map(fn ($word) => Str::substr($word, 0, 1))
    //         ->implode('');
    // }

    // /**
    //  * Check if user has a specific role
    //  */
    // public function hasRole(string $roleName)
    // {
    //     return $this->role && $this->role->name === $roleName;
    // }

    // /**
    //  * Check if user has any of the given roles
    //  */
    // public function hasAnyRole(Array $roleNames)
    // {
    //     if (is_string($roleNames)) {
    //         $roleNames = [$roleNames];
    //     }

    //     return $this->role && in_array($this->role->name, $roleNames);
    // }

    // /**
    //  * Get user's role name
    //  */
    // public function getRoleName()
    // {
    //     return $this->role ? $this->role->name : null;
    // }

    // /**
    //  * Get user's permissions
    //  */
    // public function getPermissions()
    // {
    //     if (!$this->role) {
    //         return collect();
    //     }

    //     return $this->role->permissions;
    // }

    // /**
    //  * Assign role to user
    //  * If user already has a role, it will be updated/replaced
    //  */
    // public function assignRole($roleName)
    // {
    //     $role = Role::where('name', $roleName)->first();
        
    //     if (!$role) {
    //         throw new \Exception("Role '{$roleName}' not found");
    //     }

    //     // Update the role_id regardless if user already has a role or not
    //     $this->update(['role_id' => $role->id]);
        
    //     // Refresh the model to load the new relationship
    //     $this->load('role');
        
    //     return $this;
    // }

    // /**
    //  * Revoke role from user
    //  */
    // public function revokeRole($roleName)
    // {
    //     if ($this->hasRole($roleName)) {
    //         $this->update(['role_id' => null]);
    //         // Refresh the model to reflect the change
    //         $this->load('role');
    //     }
        
    //     return $this;
    // }

    // /**
    //  * Remove all roles from user
    //  */
    // public function revokeAllRoles()
    // {
    //     $this->update(['role_id' => null]);
    //     return $this;
    // }
}
