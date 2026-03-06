<?php

namespace App\Filament\Resources\PaymentAttemptResource\Pages;

use App\Filament\Resources\PaymentAttemptResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentAttempts extends ListRecords
{
    protected static string $resource = PaymentAttemptResource::class;

    public static ?string $title = 'Попытки оплат';
}

