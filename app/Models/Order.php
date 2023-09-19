<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'pack_id',
        'payment_method',
        'value',
        'status',
        'payment_code',
        'contract_name',
        'contract_cpf',
        'contract_url',
        'contract_ip',
        'contract_signed_at',
        'approved_at',
        'canceled_at',
        'expire_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'canceled_at' => 'datetime',
        'expire_at' => 'datetime',
        'contract_signed_at' => 'datetime',
    ];

    public function getExpireAt()
    {
        $days = 0;
        switch ($this->pack->validity) {
            case 'Mensal':
                $days = 30;
                break;
            case 'Semestral':
                $days = 180;
                break;
            case 'Anual':
                $days = 365;
                break;
        }

        return now()->addDays($days);
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that owns the order.
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    /**
     * Get the pack that owns the order.
     */
    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
}
