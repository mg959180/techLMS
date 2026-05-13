<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmUser extends Model
{
    // The table associated with the model.
    protected $table = 'adm_users';
    // The attributes that are mass assignable.
    protected $fillable = ['name', 'email', 'password'];
    // The attributes that should be hidden for arrays.
    protected $hidden = ['password'];
    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // Disable timestamps if not using created_at and updated_at columns
    public $timestamps = false;

    // Define a relationship to the AdmUserDetail model
    public function details()
    {
        return $this->hasOne(AdmUserDetail::class, 'user_id');
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isEditor()
    {
        return $this->role === 'editor';
    }
    public function isViewer()
    {
        return $this->role === 'viewer';    
    }
    public function isActive()
    {
        return $this->status === 'active';
    }
    
    public function isInactive()
    {
        return $this->status === 'inactive';
    }
    
    public function isLocked()
    {
        return $this->is_locked === 1;
    }

    public function isDeleted()
    {
        return $this->is_deleted === 1;
    }

    public function isAccountExpired()
    {
        return $this->account_expires_at && $this->account_expires_at->isPast();
    }

    public function isPasswordExpired()
    {   return $this->password_expires_at && $this->password_expires_at->isPast();
    }

    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }
}
