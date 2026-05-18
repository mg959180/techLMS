<?php

namespace App\Models;

use App\Constants\TableConstant;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdmUser extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    // The table associated with the model.
    protected $table = TableConstant::ADMIN_TABLE;
    // The attributes that are mass assignable.
    protected $fillable = ['name', 'email', 'password'];
    // The attributes that should be hidden for arrays.
    protected $hidden = ['password', 'remember_token'];
    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'lockout_time' => 'datetime',
        'account_expires_at' => 'datetime',
        'locked_at' => 'datetime',
        'unlocked_at' => 'datetime',
        'password_expires_at' => 'datetime',
        'password_last_changed_at' => 'datetime',
        'account_created_at' => 'datetime',
        'account_updated_at' => 'datetime',
        'account_deleted_at' => 'datetime',
        'password' => 'hashed',
    ];

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
