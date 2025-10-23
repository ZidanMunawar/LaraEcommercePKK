<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $table = 'audiences';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the categories for the audience (Many-to-Many).
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_audience', 'audience_id', 'category_id')
            ->withTimestamps();
    }
}
