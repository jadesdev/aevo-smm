<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    public function seller()
	{
		return $this->belongsTo(User::class, 'seller_id');
	}
    public function user()
	{
		return $this->belongsTo(User::class);
	}
    public function buyer()
	{
		return $this->belongsTo(User::class);
	}
    public function listing()
	{
		return $this->belongsTo(Listing::class);
	}

    public function comments()
	{
		return $this->hasMany(ListingComment::class, 'offer_id');
	}

    public function transaction()
	{
		return $this->hasOne(ListTrx::class, 'offer_id');
	}
}
