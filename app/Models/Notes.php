<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'id', 'slug','created_at','updated_at','title','contents'
    ];

    protected $hidden = [
        'id',
    ];

    public $timestamps = true;
}

