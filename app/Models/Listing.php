<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','link','account_type','amount','age','followers','about','slug','user_id','email','followings','username','password','mobile','other_info','preview','status','follower_type','image1','image2'
    ];

    protected $hidden = [
        'email','username','password','mobile','other_info','user_id'
    ];
	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function offers(){
        return $this->hasMany(ListingOffer::class);
    }
	public function transaction()
	{
		return $this->hasOne(ListTrx::class, 'listing_id');
	}

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {

            $query->where('id', 'like', "%$search%")
            ->orwhere('account_type', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%")
            ->orWhere('age', 'like', "%$search%")
            ->orWhere('link', 'like', "%$search%")
            ->orWhere('about', 'like', "%$search%");
        });
    }

    public function comments()
	{
		return $this->hasMany(ListingComment::class, 'listing_id');
	}

}
