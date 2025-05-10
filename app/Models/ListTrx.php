<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTrx extends Model
{
    use HasFactory;

    public function offer()
	{
		return $this->belongsTo(ListingOffer::class);
	}
    public function buyer()
	{
		return $this->belongsTo(User::class, 'buyer_id');
	}
    public function seller()
	{
		return $this->belongsTo(User::class, 'seller_id');
	}
    public function listing()
	{
		return $this->belongsTo(Listing::class);
	}
}
