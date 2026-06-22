<?php
namespace App\Filament\Resources\AchievementLevelResource\Pages;
use App\Filament\Resources\AchievementLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListAchievementLevels extends ListRecords { protected static string $resource = AchievementLevelResource::class; protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; } }
