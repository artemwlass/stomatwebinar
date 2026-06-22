<?php

namespace App\Filament\Resources\EquipmentReviewResource\Pages;

use App\Filament\Resources\EquipmentReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentReviews extends ListRecords
{
    protected static string $resource = EquipmentReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
