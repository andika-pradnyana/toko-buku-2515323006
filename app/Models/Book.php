<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = ["category_id", "title", "author_name", "price"];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
