<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        'refilled_at',
    ];

    protected $hidden = [
        'error_message',
        'deleted_at',
        'error',
        'sub_posts',
        'sub_min',
        'sub_max',
        'sub_delay',
        'sub_expiry',
        'sub_response_orders',
        'sub_response_posts',
        'image',
        'sub_status',
        'reason',
        'added_on', 'response', 'user_id', 'profit', 'amount',

    ];

    protected $appends = ['service_name', 'service_type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $params = ['category:name', 'service:name', 'user:username', 'user:fname', 'user:lname', 'user:email', 'service:name'];
            $query->where(function ($q) use ($params, $search) {
                foreach ($params as $key => $param) {
                    $relationData = explode(':', $param);
                    if (@$relationData[1]) {
                        $q = $this->relationSearch($q, $relationData[0], $relationData[1], $search);
                    } else {
                        $column = $param;
                        $q->orWhere($column, 'LIKE', $search);
                    }
                }
            })
                ->orwhere('id', 'like', "%$search%")
                ->orwhere('link', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('quantity', 'like', "%$search%")
                ->orWhere('response', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%");
        });
    }

    private function relationSearch($query, $relation, $columns, $search)
    {
        foreach (explode(',', $columns) as $column) {
            $query->orWhereHas($relation, function ($q) use ($column, $search) {
                $q->where($column, 'like', "%$search%");
            });
        }

        return $query;
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    public function getServiceNameAttribute()
    {
        return $this->service->name ?? 'None';
    }

    public function getServiceTypeAttribute()
    {
        return $this->service->type ?? 'default';
    }
}
