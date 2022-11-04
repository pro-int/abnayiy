<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'promotion_name',
        'required_points',
        'description',
        'color',
        'is_fixed',
        'is_default',
        'active',
    ];

    public static function categories($returnArray = true, $category_id = null)
    {

        $categories = Category::orderBy('id')->where('active', 1);
        if (null !== $category_id) {
            $categories = $categories->where('id', $category_id);
        }

        if ($returnArray) {
            return $categories->pluck('category_name', 'id')->toArray();
        }

        return  $categories->select('category_name', 'id')->get();
    }
}
