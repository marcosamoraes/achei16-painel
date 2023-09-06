<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'cpf_cnpj',
        'phone',
        'phone2',
        'cep',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    /**
     * The attributes that should be append.
     */
    protected $appends = [
        'total_visits',
    ];

    /**
     * Get the user that owns the seller.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the companies for the client.
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    protected function totalVisits(): Attribute
    {
        return Attribute::get(fn () => $this->companies->sum('visits'));
    }
}
