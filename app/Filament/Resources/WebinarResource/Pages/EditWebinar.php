<?php

namespace App\Filament\Resources\WebinarResource\Pages;

use App\Filament\Resources\WebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditWebinar extends EditRecord
{
    protected static string $resource = WebinarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->record->title . ' - Редактирование');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $filteredData = [];
        foreach ($data['content'] as $value) {
            $filteredItem = [];

            if ($value['type'] == 0) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['date'] = $value['date'];
                $filteredItem['time'] = $value['time'];
                $filteredItem['title'] = $value['title'];
                $filteredItem['price'] = $value['price'];
                $filteredItem['tags'] = $value['tags'];
                $filteredItem['banner'] = $value['banner'];
            }

            if ($value['type'] == 1) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['title'] = $value['title'];
                $filteredItem['description'] = $value['description'];
                $filteredItem['title2'] = $value['title2'];
                $filteredItem['description2'] = $value['description2'];
                $filteredItem['title3'] = $value['title3'];
                $filteredItem['description3'] = $value['description3'];
            }

            if ($value['type'] == 2) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['image'] = $value['image'];
                $filteredItem['description'] = $value['description'];
            }

            if ($value['type'] == 3) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['lead'] = $value['lead'];
                $filteredItem['date'] = $value['date'];
                $filteredItem['time'] = $value['time'];
                $filteredItem['title'] = $value['title'];
                $filteredItem['price'] = $value['price'];
            }

            if ($value['type'] == 4) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['active'] = $value['active'];
            }

            if ($value['type'] == 5) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['image'] = $value['image'];
                $filteredItem['description'] = $value['description'];
                $filteredItem['description2'] = $value['description2'];
            }

            if ($value['type'] == 6) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['images'] = $value['images'];
            }

            if ($value['type'] == 7) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['image'] = $value['image'];
                $filteredItem['description'] = $value['description'];
                $filteredItem['description2'] = $value['description2'];
            }

            if ($value['type'] == 8) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['image'] = $value['image'];
                $filteredItem['description'] = $value['description'];
            }

            if ($value['type'] == 9) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['webinar1'] = $value['webinar1'];
                $filteredItem['webinar2'] = $value['webinar2'];
                $filteredItem['webinar3'] = $value['webinar3'];

            }

            if ($value['type'] == 10) {
                $filteredItem['type'] = $value['type'];
                $filteredItem['date'] = $value['date'];
                $filteredItem['time'] = $value['time'];
                $filteredItem['title'] = $value['title'];
                $filteredItem['price'] = $value['price'];
                $filteredItem['old_price'] = $value['old_price'];
                $filteredItem['tags'] = $value['tags'];
                $filteredItem['banner'] = $value['banner'];
            }


            if (!empty($filteredItem)) {
                $filteredData[] = $filteredItem;
            }
        }

        $data['content'] = $filteredData;
        //dd($data);

        return $data;
    }
}
