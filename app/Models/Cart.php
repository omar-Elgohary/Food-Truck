<?php
namespace App\Models;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function customers()
    {
        return $this->hasmany(User::class, 'customer_id');
    }

    public function sellers()
    {
        return $this->hasmany(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->hasmany(Product::class);
    }
}
