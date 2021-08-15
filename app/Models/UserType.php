<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;

    protected $table = 'user_types';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_type_id', 'id');
    }
}
