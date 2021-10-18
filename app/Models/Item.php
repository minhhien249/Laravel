<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}

