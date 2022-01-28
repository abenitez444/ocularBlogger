<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    /** DB Table roles**/
    protected $table = 'roles';
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description'
    ];
}
