<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'response',
        'deleted_at', 'trx',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $params = ['user:username', 'user:lname', 'user:fname', 'user:email'];
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
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('gateway', 'like', "%$search%")
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
