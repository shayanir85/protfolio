<?php

namespace App\Filament\Pages;

use App\Models\EavEntity;
use App\Models\Page as PageModel;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class PageBuilder extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Page Builder';

    protected static ?string $title = 'Page Builder';

    protected string $view = 'filament.pages.page-builder';

    public ?array $pageLayout = ['rows' => []];

    public ?PageModel $pageRecord = null;

    public array $blockTypes = [
        'about_blurb' => 'About Blurb',
        'profile_image' => 'Profile Image',
        'skill_set' => 'Skill Set',
        'experience_item' => 'Experience Item',
        'pricing_tier' => 'Pricing Tier',
        'contact_info' => 'Contact Info',
        'projects' => 'Projects',
    ];

    public ?string $modalMode = 'create';
    public ?string $selectedRowId = null;
    public ?string $selectedColumnId = null;
    public ?string $selectedBlockId = null;
    public ?string $selectedBlockType = null;
    public array $modalData = [];
    public ?int $editingEntityId = null;

    public function mount(): void
    {
        $this->pageRecord = PageModel::firstOrCreate(
            ['slug' => 'home'],
            ['layout' => ['rows' => []]]
        );
        $this->pageLayout = $this->pageRecord->layout ?? ['rows' => []];
    }

    public function addRow(): void
    {
        $rows = $this->pageLayout['rows'] ?? [];
        $rows[] = [
            'id' => 'row_' . Str::random(8),
            'columns' => [
                [
                    'id' => 'col_' . Str::random(8),
                    'width' => 12,
                    'blocks' => [],
                ],
            ],
        ];
        $this->pageLayout['rows'] = $rows;
    }

    public function deleteRow(string $rowId): void
    {
        $rows = collect($this->pageLayout['rows'] ?? [])
            ->reject(fn ($r) => $r['id'] === $rowId)
            ->values()
            ->toArray();
        $this->pageLayout['rows'] = $rows;
    }

    public function addColumn(string $rowId): void
    {
        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $rowId) {
                $row['columns'][] = [
                    'id' => 'col_' . Str::random(8),
                    'width' => 6,
                    'blocks' => [],
                ];
            }
        }
        $this->pageLayout['rows'] = $rows;
    }

    public function deleteColumn(string $rowId, string $colId): void
    {
        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $rowId) {
                $row['columns'] = collect($row['columns'])
                    ->reject(fn ($c) => $c['id'] === $colId)
                    ->values()
                    ->toArray();
            }
        }
        $this->pageLayout['rows'] = $rows;
    }

    public function columnWidth(string $rowId, string $colId, int $width): void
    {
        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $rowId) {
                foreach ($row['columns'] as &$col) {
                    if ($col['id'] === $colId) {
                        $col['width'] = $width;
                    }
                }
            }
        }
        $this->pageLayout['rows'] = $rows;
    }

    public function openAddBlockModal(string $rowId, string $colId): void
    {
        $this->selectedRowId = $rowId;
        $this->selectedColumnId = $colId;
        $this->modalMode = 'create';
        $this->selectedBlockType = null;
        $this->modalData = [];
        $this->editingEntityId = null;
        $this->dispatch('open-modal', id: 'selectBlockType');
    }

    public function selectBlockType(string $type): void
    {
        $this->selectedBlockType = $type;

        if ($type === 'projects') {
            $this->createBlock(null);
            $this->dispatch('close-modal', id: 'selectBlockType');
            return;
        }

        $this->dispatch('close-modal', id: 'selectBlockType');
        $this->dispatch('open-modal', id: 'blockContent');
    }

    public function createBlock(?array $data = null): void
    {
        $type = $this->selectedBlockType;

        if ($type !== 'projects' && $data) {
            if (isset($data['tech_stack_string'])) {
                $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack_string']));
                unset($data['tech_stack_string']);
            }
            $entity = EavEntity::create([
                'type' => $type,
                'data' => $data,
            ]);
            $entityId = $entity->id;
        } else {
            $entityId = null;
        }

        $block = [
            'id' => 'block_' . Str::random(8),
            'entity_id' => $entityId,
            'type' => $type,
        ];

        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $this->selectedRowId) {
                foreach ($row['columns'] as &$col) {
                    if ($col['id'] === $this->selectedColumnId) {
                        $col['blocks'][] = $block;
                    }
                }
            }
        }
        $this->pageLayout['rows'] = $rows;
        $this->dispatch('close-modal', id: 'blockContent');
    }

    public function openEditBlockModal(string $rowId, string $colId, string $blockId): void
    {
        $this->selectedRowId = $rowId;
        $this->selectedColumnId = $colId;
        $this->selectedBlockId = $blockId;

        $block = $this->findBlock($rowId, $colId, $blockId);
        if (!$block) return;

        $this->selectedBlockType = $block['type'];

        if ($block['type'] === 'projects') return;

        $entity = EavEntity::find($block['entity_id']);
        if (!$entity) return;

        $this->editingEntityId = $entity->id;
        $this->modalData = $entity->data;
        $this->modalMode = 'edit';
        $this->dispatch('open-modal', id: 'blockContent');
    }

    public function updateBlock(array $data): void
    {
        if ($this->editingEntityId) {
            if (isset($data['tech_stack_string'])) {
                $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack_string']));
                unset($data['tech_stack_string']);
            }
            $entity = EavEntity::find($this->editingEntityId);
            if ($entity) {
                $entity->update(['data' => $data]);
            }
        }
        $this->dispatch('close-modal', id: 'blockContent');
    }

    public function deleteBlock(string $rowId, string $colId, string $blockId): void
    {
        $block = $this->findBlock($rowId, $colId, $blockId);
        if ($block && $block['entity_id']) {
            EavEntity::destroy($block['entity_id']);
        }

        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $rowId) {
                foreach ($row['columns'] as &$col) {
                    if ($col['id'] === $colId) {
                        $col['blocks'] = collect($col['blocks'])
                            ->reject(fn ($b) => $b['id'] === $blockId)
                            ->values()
                            ->toArray();
                    }
                }
            }
        }
        $this->pageLayout['rows'] = $rows;
    }

    public function moveBlockUp(string $rowId, string $colId, string $blockId): void
    {
        $this->moveBlock($rowId, $colId, $blockId, -1);
    }

    public function moveBlockDown(string $rowId, string $colId, string $blockId): void
    {
        $this->moveBlock($rowId, $colId, $blockId, 1);
    }

    private function moveBlock(string $rowId, string $colId, string $blockId, int $direction): void
    {
        $rows = $this->pageLayout['rows'] ?? [];
        foreach ($rows as &$row) {
            if ($row['id'] === $rowId) {
                foreach ($row['columns'] as &$col) {
                    if ($col['id'] === $colId) {
                        $blocks = $col['blocks'];
                        $idx = collect($blocks)->search(fn ($b) => $b['id'] === $blockId);
                        if ($idx === false) return;
                        $newIdx = $idx + $direction;
                        if ($newIdx < 0 || $newIdx >= count($blocks)) return;
                        [$blocks[$idx], $blocks[$newIdx]] = [$blocks[$newIdx], $blocks[$idx]];
                        $col['blocks'] = $blocks;
                    }
                }
            }
        }
        $this->pageLayout['rows'] = $rows;
    }

    private function findBlock(string $rowId, string $colId, string $blockId): ?array
    {
        foreach ($this->pageLayout['rows'] ?? [] as $row) {
            if ($row['id'] !== $rowId) continue;
            foreach ($row['columns'] ?? [] as $col) {
                if ($col['id'] !== $colId) continue;
                foreach ($col['blocks'] ?? [] as $block) {
                    if ($block['id'] === $blockId) return $block;
                }
            }
        }
        return null;
    }

    public function addSkill(): void
    {
        $skills = $this->modalData['skills'] ?? [];
        $skills[] = ['name' => '', 'level' => 0];
        $this->modalData['skills'] = $skills;
    }

    public function removeSkill(int $index): void
    {
        $skills = $this->modalData['skills'] ?? [];
        unset($skills[$index]);
        $this->modalData['skills'] = array_values($skills);
    }

    public function addFeature(): void
    {
        $features = $this->modalData['features'] ?? [];
        $features[] = '';
        $this->modalData['features'] = $features;
    }

    public function removeFeature(int $index): void
    {
        $features = $this->modalData['features'] ?? [];
        unset($features[$index]);
        $this->modalData['features'] = array_values($features);
    }

    public function save(): void
    {
        $this->pageRecord->update(['layout' => $this->pageLayout]);
        Notification::make()
            ->title('Page layout saved successfully!')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addRow')
                ->label('Add Row')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->action('addRow'),
            Action::make('save')
                ->label('Save Layout')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('save'),
        ];
    }
}
