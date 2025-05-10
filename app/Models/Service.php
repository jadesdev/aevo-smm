<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    public function category()
	{
		return $this->belongsTo(Category::class)->withDefault();
	}

	public function provider()
	{
		return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
	}

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected $fillable = [
        'category_id',
        'api_provider_id',
        'api_service_id',
        'manual_api',
        'name',
        'min',
        'price', 'api_price',
        'max',
        'status',
        'dripfeed',
        'refill',
        'type',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        "updated_at",
        "api_price",
    ];

}
