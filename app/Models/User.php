<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'username',
        'fname',
        'lname',
        'password',
        'user_role',
        'email_verified_at',
        'email_verify'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'blocked',
        'verify_code',
        'email_verify',
        'sms_verify',
        'name',
        'fname',
        'lname',
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['fullname'];

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_id')->where('ref_id', $this->id);
    }

    public function getFullnameAttribute()
    {
        return $this->fname.' '.$this->lname;
    }

    public function name()
    {
        return $this->fname.' '.$this->lname;
    }

    public function refer()
    {
        return $this->belongsTo(User::class, 'ref_id');
    }

    public function ticket_comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderByDesc('id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->orderByDesc('id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class)->orderByDesc('id');
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class)->orderByDesc('id');
    }

    public function notify()
    {
        return $this->hasMany(Notification::class);
    }

    public function notifys()
    {
        return $this->hasMany(Notification::class)->orderByDesc('updated_at')->whereView(0);
    }

    public function scopeSearchUser($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('balance', 'like', "%$search%")
                ->orWhere('fname', 'like', "%$search%")
                ->orWhere('lname', 'like', "%$search%")
                ->orWhere('bonus', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        });
    }
}
