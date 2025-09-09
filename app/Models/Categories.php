<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
     use HasFactory, SoftDeletes;

    protected $table = 'categories';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'order',
        'published_at',
        'archived_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
        'status' => 'boolean'
    ];

   public function getFullPath()
{
    $path = [];

    if ($this->parent) {
        if ($this->parent->parent) {
            $path[] = $this->parent->parent->name;
        }
        $path[] = $this->parent->name;
    }
    
    $path[] = $this->name;

    return implode(' > ', $path);
}

 
    public function parent() { return $this->belongsTo(Categories::class, 'parent_id'); }
    public function children() { return $this->hasMany(Categories::class, 'parent_id'); }
    public function articles() { return $this->hasMany(Article::class,'category_id'); }
}
