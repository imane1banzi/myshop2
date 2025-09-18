<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'fullname',
    'email',
    'address',
    'phone',
    'total_price',
    'cart_data',
    'status',
    'delivery_comment',
];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    // si tu as un modèle PromoCode
public function promoCode()
{
    return $this->belongsTo(PromoCode::class, 'coupon_code', 'code');
}

}
