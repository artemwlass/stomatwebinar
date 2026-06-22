<?php

namespace App\Filament\Resources\ClinicalCaseResource\Pages;

use App\Filament\Resources\ClinicalCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClinicalCases extends ListRecords
{
    protected static string $resource = ClinicalCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
