<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'description',
        'phone',
        'phone2',
        'opening_hours',
        'opening_24h',
        'cep',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'email',
        'site',
        'facebook',
        'instagram',
        'youtube',
        'google_my_business',
        'ifood',
        'waze',
        'olx',
        'payment_methods',
        'image',
        'images',
        'featured',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * The attributes that should be appended.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
        'images_url',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? asset('storage/' . $this->image) : null);
    }

    protected function imagesUrl(): Attribute
    {
        return Attribute::get(fn () => $this->images ? collect($this->images)->map(fn ($image) => asset('storage/' . $image)) : null);
    }

    /**
     * Get the user that register the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client that owns the company.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the categories for the company.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'company_categories');
    }

    /**
     * Get the tags for the company.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'company_tags');
    }
}
