<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    /** DB Table categories**/
    protected $table = 'categories';
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description'
    ];
}
