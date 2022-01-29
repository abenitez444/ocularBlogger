<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    /** DB Table categories**/
    protected $table = 'publications';
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'image',
        'title',
        'user_id',
        'category_id',
        'description'
    ];
}
