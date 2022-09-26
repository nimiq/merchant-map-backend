<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'issue_category_id',
        'description'
    ];

    /**
     * Get the category associated with this issue
     */
    public function issue_category()
    {
        return $this->belongsTo(IssueCategory::class);
    }

    /**
     * Get the shop associated with this issue
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
