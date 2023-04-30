<?php
namespace App\Models;
use App\Models\Image;
use App\Models\Section;
use App\Models\Without;
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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function withouts()
    {
        return $this->hasMany(Without::class, 'without_id');
    }
}
