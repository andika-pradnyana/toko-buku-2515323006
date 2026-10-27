<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = ["category_id", "publisher_id", "title", "author_name", "price", "cover"];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function publisher(): BelongsTo {
        return $this->belongsTo(Publisher::class);
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cover
                ? asset('storage/' . $this->cover)
                : asset('images/sampul-placeholder.png'),
        );
    }

}
