<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmUserDetail extends Model
{
    // The table associated with the model.
    protected $table = 'adm_user_details';
    // The attributes that are mass assignable.
    protected $fillable = ['user_id', 'address', 'phone_number'];
    // Disable timestamps if not using created_at and updated_at columns
    public $timestamps = false;

    // Define a relationship to the AdmUser model
    public function user()
    {
        return $this->belongsTo(AdmUser::class, 'user_id');
    }

    public function getFullAddressAttribute()
    {
        return $this->address; // Assuming address is a single field, you can modify this if you have separate fields for street, city, etc.
    }

    public function getPhoneNumberAttribute($value)
    {
        // Format the phone number as needed, for example: (123) 456-7890
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $value);
    }

    public function setPhoneNumberAttribute($value)
    {
        // Remove any non-numeric characters before saving
        $this->attributes['phone_number'] = preg_replace('/\D/', '', $value);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path) : null;
    }


    public function setProfilePhotoPathAttribute($value)
    {
        // Handle file upload and save the path to the database
        if ($value) {
            $this->attributes['profile_photo_path'] = $value->store('profile_photos', 'public');
        }
    }   

    public function getDateOfBirthAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getTimezoneAttribute($value)
    {
        return $value ?: config('app.timezone');
    }

    public function getLanguageAttribute($value)
    {
        return $value ?: config('app.locale');
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function getDeletedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOlderThan($query, $date)
    {
        return $query->where('created_at', '<', $date);
    }

    public function scopeYoungerThan($query, $date)
    {
        return $query->where('created_at', '>', $date);
    }
    public function scopeWithProfilePhoto($query)
    {
        return $query->whereNotNull('profile_photo_path');
    }
    public function scopeWithoutProfilePhoto($query)
    {
        return $query->whereNull('profile_photo_path');
    }
    public function scopeOfTimezone($query, $timezone)
    {
        return $query->where('timezone', $timezone);
    }
    public function scopeOfLanguage($query, $language)
    {
        return $query->where('language', $language);
    }
    public function scopeOfCity($query, $city)
    {
        return $query->where('city', $city);
    }
    public function scopeOfState($query, $state)
    {
        return $query->where('state', $state);
    }
    public function scopeOfCountry($query, $country)
    {
        return $query->where('country', $country);
    }
    public function scopeOfPostalCode($query, $postalCode)
    {
        return $query->where('postal_code', $postalCode);
    }
    public function scopeOfDateOfBirth($query, $dateOfBirth)
    {
        return $query->where('date_of_birth', $dateOfBirth);
    }
    public function scopeOfPhoneNumber($query, $phoneNumber)
    {
        return $query->where('phone_number', preg_replace('/\D/', '', $phoneNumber));
    }
    
    
}
