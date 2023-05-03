<?php
namespace App\Models;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function withouts()
    {
        return $this->hasMany(Without::class, 'without_id');
    }


    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
