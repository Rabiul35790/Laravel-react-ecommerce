<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    public function parent(): BelongsTo {
        //stablish parent child category
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
