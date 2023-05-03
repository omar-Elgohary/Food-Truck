<?php
namespace App\Models;
use App\Models\Image;
use App\Models\Section;
use App\Models\Without;
use App\Models\FoodType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function foodType()
    {
        return $this->belongsTo(FoodType::class, 'food_type_id');
    }


    public function section()
    {
        return $this->belongsTo(Section::class);
    }


}
