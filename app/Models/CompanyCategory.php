<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'category_id',
    ];

    /**
     * Get the company that owns the company category.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category that owns the company category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
