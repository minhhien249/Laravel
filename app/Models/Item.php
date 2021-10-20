<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'stock',
        'user_id',
        'category_id',
        'is_active',
    ];
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public static function getAll()
    {
        $item = Item::latest()->paginate(20);

        return $item;
    }
    public static function updateDB($id)
    {
        $data = Item::findorFail($id);


        return $data->save();
    }
    public static function getById($id)
    {
        $item = Item::findorFail($id);

        return $item;
    }
    public static function createDB($item)
    {
        $data = Item::create($item);

        return $data->save();
    }
    public static function deleteDB($id)
    {
       Item::where('id', $id)->delete();

    }
    public static function searchKeyWord($keyword)
    {
        $data = [];
        $data = Item::where(['name', 'like', '%' . $keyword . '%'])
                      ->orWhere(['email', 'like', '%' . $keyword . '%'])
                      ->paginate(10);

        return $data;
    }
}

