<?php

namespace App\Enums;

enum TransactionType: int
{
    case Debit = 0;
    case Accrual = 1;

    public function label(): string
    {
        return match ($this) {
            self::Debit => 'Списание',
            self::Accrual => 'Начисление',
        };
    }
}
