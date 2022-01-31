<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Publication extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    /** DB Table publication**/
    protected $table = 'publications';
    protected $dates = ['deleted_at'];
    protected $casts = [
      'created_at' => "datetime:d-m-Y / h:i a",
    ];
    
    protected $fillable = [
        'image',
        'title',
        'user_id',
        'category_id',
        'summary',
        'description',

    ];

    public function category()
    {
      return $this->belongsTo(Category::class, 'category_id');
    }
    public function author()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

}
