<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'title',
        'description',
        'value',
        'validity',
        'status',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
