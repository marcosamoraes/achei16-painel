<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyTag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'tag_id',
    ];

    /**
     * Get the company that owns the company category.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the tag that owns the company category.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
