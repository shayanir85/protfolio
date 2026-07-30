<x-filament-panels::page>
    <div class="space-y-6">
        @if (empty($pageLayout['rows']))
            <div class="text-center text-gray-400 py-12">
                <p class="text-lg">No rows yet. Click "Add Row" to start building your page.</p>
            </div>
        @else
            @foreach ($pageLayout['rows'] as $rowIndex => $row)
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-white dark:bg-gray-800 relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-gray-500">Row {{ $rowIndex + 1 }}</span>
                        <div class="flex gap-2">
                            <x-filament::button
                                icon="heroicon-o-plus"
                                size="xs"
                                color="gray"
                                wire:click="addColumn('{{ $row['id'] }}')"
                            >
                                Add Column
                            </x-filament::button>
                            <x-filament::button
                                icon="heroicon-o-trash"
                                size="xs"
                                color="danger"
                                wire:click="deleteRow('{{ $row['id'] }}')"
                                wire:confirm="Delete this row?"
                            />
                        </div>
                    </div>

                    <div class="flex gap-4">
                        @foreach ($row['columns'] as $colIndex => $column)
                            <div
                                class="flex-1 border border-gray-200 rounded-lg p-3 bg-gray-50 dark:bg-gray-700 relative"
                                style="max-width: {{ ($column['width'] / 12) * 100 }}%"
                            >
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-400">Col {{ $colIndex + 1 }}</span>
                                        <select
                                            class="text-xs border rounded px-1 py-0.5"
                                            wire:change="columnWidth('{{ $row['id'] }}', '{{ $column['id'] }}', $event.target.value)"
                                        >
                                            @foreach ([3, 4, 6, 8, 12] as $w)
                                                <option value="{{ $w }}" @selected($column['width'] === $w)>
                                                    {{ $w }}/12
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex gap-1">
                                        <x-filament::button
                                            icon="heroicon-o-plus-circle"
                                            size="xs"
                                            color="success"
                                            wire:click="openAddBlockModal('{{ $row['id'] }}', '{{ $column['id'] }}')"
                                        >
                                            Add Block
                                        </x-filament::button>
                                        <x-filament::button
                                            icon="heroicon-o-x-mark"
                                            size="xs"
                                            color="danger"
                                            wire:click="deleteColumn('{{ $row['id'] }}', '{{ $column['id'] }}')"
                                            wire:confirm="Delete this column?"
                                        />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    @forelse ($column['blocks'] ?? [] as $blockIndex => $block)
                                        <div class="bg-white dark:bg-gray-600 border rounded p-2 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-mono bg-gray-200 dark:bg-gray-500 px-1.5 py-0.5 rounded">
                                                    {{ $blockTypes[$block['type']] ?? $block['type'] }}
                                                </span>
                                                @if ($block['entity_id'])
                                                    <span class="text-xs text-gray-400">#{{ $block['entity_id'] }}</span>
                                                @endif
                                            </div>
                                            <div class="flex gap-1">
                                                <x-filament::button
                                                    icon="heroicon-o-chevron-up"
                                                    size="xs"
                                                    color="gray"
                                                    wire:click="moveBlockUp('{{ $row['id'] }}', '{{ $column['id'] }}', '{{ $block['id'] }}')"
                                                />
                                                <x-filament::button
                                                    icon="heroicon-o-chevron-down"
                                                    size="xs"
                                                    color="gray"
                                                    wire:click="moveBlockDown('{{ $row['id'] }}', '{{ $column['id'] }}', '{{ $block['id'] }}')"
                                                />
                                                <x-filament::button
                                                    icon="heroicon-o-pencil"
                                                    size="xs"
                                                    color="warning"
                                                    wire:click="openEditBlockModal('{{ $row['id'] }}', '{{ $column['id'] }}', '{{ $block['id'] }}')"
                                                />
                                                <x-filament::button
                                                    icon="heroicon-o-trash"
                                                    size="xs"
                                                    color="danger"
                                                    wire:click="deleteBlock('{{ $row['id'] }}', '{{ $column['id'] }}', '{{ $block['id'] }}')"
                                                    wire:confirm="Delete this block?"
                                                />
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-400 text-center py-2">No blocks</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Block type selection modal --}}
    <x-filament::modal id="selectBlockType" width="md">
        <x-slot name="heading">Select Block Type</x-slot>
        <div class="grid grid-cols-2 gap-3 p-4">
            @foreach ($blockTypes as $type => $label)
                <x-filament::button
                    color="gray"
                    class="!justify-start"
                    wire:click="selectBlockType('{{ $type }}')"
                >
                    {{ $label }}
                </x-filament::button>
            @endforeach
        </div>
        <x-slot name="footer">
            <x-filament::button color="gray" x-on:click="close()">
                Cancel
            </x-filament::button>
        </x-slot>
    </x-filament::modal>

    {{-- Block content form modal --}}
    <x-filament::modal id="blockContent" width="lg">
        <x-slot name="heading">
            {{ $modalMode === 'create' ? 'Add' : 'Edit' }} {{ $blockTypes[$selectedBlockType] ?? $selectedBlockType ?? 'Block' }}
        </x-slot>
        <div class="space-y-4 p-4">
            @if ($selectedBlockType === 'about_blurb')
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" wire:model.live="modalData.title" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Text</label>
                    <textarea wire:model.live="modalData.text" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Avatar URL</label>
                    <input type="text" wire:model.live="modalData.avatar_url" class="w-full border rounded px-3 py-2" />
                </div>

            @elseif ($selectedBlockType === 'profile_image')
                <div>
                    <label class="block text-sm font-medium mb-1">Image URL</label>
                    <input type="text" wire:model.live="modalData.image_url" class="w-full border rounded px-3 py-2" />
                </div>

            @elseif ($selectedBlockType === 'skill_set')
                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <input type="text" wire:model.live="modalData.category" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Skills</label>
                    <div class="space-y-2">
                        @foreach (($modalData['skills'] ?? []) as $skillIndex => $skill)
                            <div class="flex gap-2 items-center">
                                <input type="text" wire:model.live="modalData.skills.{{ $skillIndex }}.name" placeholder="Name" class="flex-1 border rounded px-2 py-1 text-sm" />
                                <input type="number" wire:model.live="modalData.skills.{{ $skillIndex }}.level" placeholder="Level" min="0" max="100" class="w-20 border rounded px-2 py-1 text-sm" />
                                <button type="button" wire:click="removeSkill({{ $skillIndex }})" class="text-red-500 text-sm">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addSkill" class="text-sm text-primary-600 mt-1">+ Add Skill</button>
                </div>

            @elseif ($selectedBlockType === 'experience_item')
                <div>
                    <label class="block text-sm font-medium mb-1">Company</label>
                    <input type="text" wire:model.live="modalData.company" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Position</label>
                    <input type="text" wire:model.live="modalData.position" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="text" wire:model.live="modalData.start_date" placeholder="2022-01" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="text" wire:model.live="modalData.end_date" placeholder="2024-12" class="w-full border rounded px-3 py-2" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea wire:model.live="modalData.description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tech Stack (comma separated)</label>
                    <input type="text" wire:model.live="modalData.tech_stack_string" placeholder="Laravel, Vue, AWS" class="w-full border rounded px-3 py-2" />
                </div>

            @elseif ($selectedBlockType === 'pricing_tier')
                <div>
                    <label class="block text-sm font-medium mb-1">Plan Name</label>
                    <input type="text" wire:model.live="modalData.plan_name" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price</label>
                    <input type="text" wire:model.live="modalData.price" placeholder="$49/mo" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Features</label>
                    <div class="space-y-1">
                        @foreach (($modalData['features'] ?? []) as $fIndex => $feature)
                            <div class="flex gap-2">
                                <input type="text" wire:model.live="modalData.features.{{ $fIndex }}" class="flex-1 border rounded px-2 py-1 text-sm" />
                                <button type="button" wire:click="removeFeature({{ $fIndex }})" class="text-red-500 text-sm">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addFeature" class="text-sm text-primary-600 mt-1">+ Add Feature</button>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">CTA Text</label>
                    <input type="text" wire:model.live="modalData.cta_text" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">CTA Link</label>
                    <input type="text" wire:model.live="modalData.cta_link" class="w-full border rounded px-3 py-2" />
                </div>

            @elseif ($selectedBlockType === 'contact_info')
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" wire:model.live="modalData.email" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" wire:model.live="modalData.phone" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">GitHub URL</label>
                    <input type="text" wire:model.live="modalData.social_links.github" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">LinkedIn URL</label>
                    <input type="text" wire:model.live="modalData.social_links.linkedin" class="w-full border rounded px-3 py-2" />
                </div>
            @endif
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-2">
                <x-filament::button color="gray" x-on:click="close()">
                    Cancel
                </x-filament::button>
                <x-filament::button
                    color="primary"
                    wire:click="{{ $modalMode === 'create' ? 'createBlock(modalData)' : 'updateBlock(modalData)' }}"
                >
                    {{ $modalMode === 'create' ? 'Create' : 'Update' }}
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::modal>

</x-filament-panels::page>
