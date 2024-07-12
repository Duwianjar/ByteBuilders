<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['id_depository','transaction', 'id_category', 'id_user', 'description', 'amount'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    
    public function depository()
    {
        return $this->belongsTo(Depository::class, 'id_depository');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}