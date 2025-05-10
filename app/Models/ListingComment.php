<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingComment extends Model
{
    use HasFactory;

    public $fillable = [
        'listing_id',
        'offer_id',
        'type',
        'message',
    ];

    public function offer()
    {
        return $this->belongsTo(ListingOffer::class);
    }
}
