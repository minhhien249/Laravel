<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function items(){
        return $this->hasMany(Item::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'delete_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function  createDB(array $user)
    {
        $data = User::create($user);

        return $data->save();
    }
    public static function searchKeyWord($keyword)
    {
        $data = [];
        $data = User::where(['name', 'like', '%' . $keyword . '%'])
                                  ->orWhere(['email', 'like', '%' . $keyword . '%'])
                                  ->paginate(10);

        return $data;
    }
    public static function getAll()
    {
        $data = User::latest()->paginate(20);

        return $data;
    }

}
