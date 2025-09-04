<?php

namespace App\Filament\Resources\FreeWebinarPreorderResource\Pages;

use App\Filament\Resources\FreeWebinarPreorderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditFreeWebinarPreorder extends EditRecord
{
    protected static string $resource = FreeWebinarPreorderResource::class;

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

    /**
     * НОРМАЛИЗАЦИЯ legacy-данных до показа формы (добавляем field_type/options).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $content = $data['content'] ?? [];
        if (!is_array($content)) {
            $data['content'] = [];
            return $data;
        }

        foreach ($content as &$block) {
            if (($block['type'] ?? null) == 11) {
                // form_enabled: берём из нового или из старого boolean form
                if (!array_key_exists('form_enabled', $block)) {
                    $block['form_enabled'] = (bool)($block['form'] ?? true);
                } else {
                    $block['form_enabled'] = (bool)$block['form_enabled'];
                }

                // привести старый одиночный вопрос к массиву
                if (isset($block['form_question']) && is_string($block['form_question'])) {
                    $fq = trim($block['form_question']);
                    $block['form'] = $fq !== '' ? [['form_question' => $fq]] : [];
                    unset($block['form_question']);
                }

                // гарантировать массив
                if (!isset($block['form']) || !is_array($block['form'])) {
                    $block['form'] = [];
                }

                // для каждого элемента — задать field_type и options по умолчанию
                foreach ($block['form'] as &$row) {
                    if (!is_array($row)) {
                        $row = [];
                    }
                    // вопрос
                    $row['form_question'] = isset($row['form_question']) ? (string)$row['form_question'] : '';
                    // тип (по умолчанию text)
                    $row['field_type'] = $row['field_type'] ?? 'text';
                    // варианты: только массив строк
                    if (!isset($row['options']) || !is_array($row['options'])) {
                        $row['options'] = [];
                    } else {
                        $row['options'] = array_values(array_filter(array_map(
                            fn($v) => trim((string)$v),
                            $row['options']
                        ), fn($s) => $s !== ''));
                    }
                }
                unset($row);
            }
        }
        unset($block);

        $data['content'] = $content;
        return $data;
    }

    /**
     * Фильтрация и нормализация перед сохранением.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $filteredData = [];
        $content = $data['content'] ?? [];
        if (!is_array($content)) {
            $data['content'] = [];
            return $data;
        }

        foreach ($content as $value) {
            $filteredItem = [];

            if (($value['type'] ?? null) == 0) {
                $filteredItem['type']  = $value['type'];
                $filteredItem['date']  = $value['date'] ?? null;
                $filteredItem['time']  = $value['time'] ?? null;
                $filteredItem['title'] = $value['title'] ?? null;
                $filteredItem['price'] = $value['price'] ?? null;
                $filteredItem['tags']  = $value['tags'] ?? [];
                $filteredItem['banner']= $value['banner'] ?? null;
            }

            if (($value['type'] ?? null) == 1) {
                $filteredItem['type']         = $value['type'];
                $filteredItem['title']        = $value['title'] ?? null;
                $filteredItem['description']  = $value['description'] ?? null;
                $filteredItem['title2']       = $value['title2'] ?? null;
                $filteredItem['description2'] = $value['description2'] ?? null;
                $filteredItem['title3']       = $value['title3'] ?? null;
                $filteredItem['description3'] = $value['description3'] ?? null;
            }

            if (($value['type'] ?? null) == 2) {
                $filteredItem['type']        = $value['type'];
                $filteredItem['image']       = $value['image'] ?? null;
                $filteredItem['description'] = $value['description'] ?? null;
            }

            if (($value['type'] ?? null) == 3) {
                $filteredItem['type']  = $value['type'];
                $filteredItem['lead']  = $value['lead'] ?? null;
                $filteredItem['date']  = $value['date'] ?? null;
                $filteredItem['time']  = $value['time'] ?? null;
                $filteredItem['title'] = $value['title'] ?? null;
                $filteredItem['price'] = $value['price'] ?? null;
            }

            if (($value['type'] ?? null) == 4) {
                $filteredItem['type']   = $value['type'];
                $filteredItem['active'] = (bool)($value['active'] ?? false);
            }

            if (($value['type'] ?? null) == 5) {
                $filteredItem['type']         = $value['type'];
                $filteredItem['image']        = $value['image'] ?? null;
                $filteredItem['description']  = $value['description'] ?? null;
                $filteredItem['description2'] = $value['description2'] ?? null;
            }

            if (($value['type'] ?? null) == 6) {
                $filteredItem['type']   = $value['type'];
                $filteredItem['images'] = $value['images'] ?? [];
            }

            if (($value['type'] ?? null) == 7) {
                $filteredItem['type']         = $value['type'];
                $filteredItem['image']        = $value['image'] ?? null;
                $filteredItem['description']  = $value['description'] ?? null;
                $filteredItem['description2'] = $value['description2'] ?? null;
            }

            if (($value['type'] ?? null) == 8) {
                $filteredItem['type']        = $value['type'];
                $filteredItem['image']       = $value['image'] ?? null;
                $filteredItem['description'] = $value['description'] ?? null;
            }

            if (($value['type'] ?? null) == 9) {
                $filteredItem['type']     = $value['type'];
                $filteredItem['webinar1'] = $value['webinar1'] ?? null;
                $filteredItem['webinar2'] = $value['webinar2'] ?? null;
                $filteredItem['webinar3'] = $value['webinar3'] ?? null;
            }

            if (($value['type'] ?? null) == 10) {
                $filteredItem['type']  = $value['type'];
                $filteredItem['video'] = $value['video'] ?? null;
            }

            if (($value['type'] ?? null) == 11) {
                $filteredItem['type']          = 11;
                $filteredItem['form_id']       = $value['form_id'] ?? null;
                $filteredItem['form_enabled']  = (bool)($value['form_enabled'] ?? true);

                $list = $value['form'] ?? [];
                if (isset($value['form_question']) && is_string($value['form_question'])) {
                    $fq = trim($value['form_question']);
                    if ($fq !== '') {
                        $list = array_merge([['form_question' => $fq, 'field_type' => 'text']], is_array($list) ? $list : []);
                    }
                }
                if (!is_array($list)) $list = [];

                $norm = [];
                foreach ($list as $row) {
                    if (!is_array($row)) continue;

                    $q = trim((string)($row['form_question'] ?? ''));
                    if ($q === '') continue;

                    $type = in_array(($row['field_type'] ?? 'text'), ['text','select'], true)
                        ? $row['field_type'] : 'text';

                    $norm[] = [
                        'form_question' => $q,
                        'field_type'    => $type,
                        // никаких options не сохраняем
                    ];
                }

                $filteredItem['form'] = $norm;
            }


            if (!empty($filteredItem)) {
                $filteredData[] = $filteredItem;
            }
        }

        $data['content'] = $filteredData;
        return $data;
    }
}
