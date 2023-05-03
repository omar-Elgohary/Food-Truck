<?php
namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected  $guarded = [];


    public function users()
    {
        return $this->belongsToMany(User::class, 'seller_id');
    }
}
