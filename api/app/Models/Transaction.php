<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
    ];

    protected $casts = [
        'type' => TransactionType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isDebit(): bool
    {
        return $this->type === TransactionType::Debit;
    }

    public function isAccrual(): bool
    {
        return $this->type === TransactionType::Accrual;
    }
}
