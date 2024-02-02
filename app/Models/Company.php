<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'slug',
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
        'google_street_view',
        'payment_methods',
        'image',
        'images',
        'featured',
        'visits',
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
        'is_approved',
        'rating'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($company) {
            $company->slug = Str::slug($company->name);
        });

        self::updating(function ($company) {
            $company->slug = Str::slug($company->name);
        });
    }

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
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the client that owns the company.
     */
    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
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

    /**
     * Get the orders for the company.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the last order approved.
     */
    public function lastOrderApproved()
    {
        return $this->hasOne(Order::class)->where('status', 'approved')->latest();
    }

    /**
     * Query build to return only companies with status = true and with an order not expired with status = approved.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', true)
            ->whereHas('orders', function ($query) {
                $query->where('status', 'approved')
                    ->where('expire_at', '>', now());
            });
    }

    /**
     * Attribute to return if the company is approved
     */
    public function isApproved(): Attribute
    {
        return Attribute::get(fn () => $this->orders()->where('status', 'approved')->where('expire_at', '>', now())->exists());
    }

    /**
     * Get the reviews for the company.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Attribute to return the rating of the company
     */
    public function rating(): Attribute
    {
        return Attribute::get(fn () => $this->reviews()->avg('rating'));
    }
}
