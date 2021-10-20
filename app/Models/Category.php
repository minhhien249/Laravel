<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'position',
        'is_active',
    ];

    public function items(){
        return $this->hasMany(Item::class);
    }
    public static function getAll()
    {
        $data = Category::all();

        return $data;
    }
    public static function  createDB(array $cate)
    {
        $data = Category::create($cate);

        return $data->save();
    }
    public static function findId($id)
    {
        $category = Category::find($id);
        return $category;
    }
}
