<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_id', 'product_id', 'order_amount', 'order_date', 'receive_date'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function getOrderStateTextAttribute()
    {
        switch($this->attributes['order_state']) {
            case 1:
                return '注文中';
            case 2;
                return '調理完了';
            case 3;
                return '受取完了';
            default:
                return '';
        }
    }
}
