<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $with = [
    'category', 
    'tags',
];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    public function scopefilters(Builder $query, array $filters): void
    {
        if (isset($filters['search'])) {            
            $query->where(fn (Builder $query) => $query
                ->where('title', 'LIKE', '%' . $filters['search'] . '%')
                ->orwhere('content', 'LIKE', '%' . $filters['search'] . '%')
            );
        }

        if (isset($filters['category'])) {
            
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
