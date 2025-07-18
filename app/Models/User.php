<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\VendorUsers;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the Vendor uuid of the authenticated user
     * @return mixed
     */
    public function getVendorId(): mixed
    {
        $authUserVendorId = Auth::user()->vendorUser->uuid;
        return $authUserVendorId ?? null;
        // $exist = VendorUsers::where('user_id', Auth::user()->id)->exists();

        // if ($exist) {
        //     return $exist->uuid;
        // } else {
        //     $exist = VendorUsers::where('email', Auth::user()->email)->first();
        //     if ($exist) {
        //         return $exist->uuid;
        //     } else {
        //         return null;
        //     }
        // }
    }

    /**
     * A User has only one VendorUser
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vendorUser(): HasOne
    {
        return $this->hasOne(VendorUsers::class, 'user_id');
    }
}
