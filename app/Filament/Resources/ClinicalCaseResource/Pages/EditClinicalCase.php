<?php

namespace App\Filament\Resources\ClinicalCaseResource\Pages;

use App\Filament\Resources\ClinicalCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClinicalCase extends EditRecord
{
    protected static string $resource = ClinicalCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
