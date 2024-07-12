<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depository extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'information',
        'color',
        'id_user',
    ];

    /**
     * Get the user that owns the depository.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'id_depository');
    }

}