<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'amount','user_id','type','code','new_balance', 'title',
        'old_balance','service','charge','message','status'
    ];

    protected $hidden = [
        'user_id',
        'response',
        "deleted_at",
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $params = ['user:username','user:lname','user:fname','user:email'];
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
            ->orWhere('service', 'like', "%$search%")
            ->orWhere('code', 'like', "%$search%")
            ->orWhere('message', 'like', "%$search%")
            ->orWhere('amount', 'like', "%$search%");
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

}
