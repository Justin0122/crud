@props(['results', 'type', 'create' => false, 'fillables' => null, 'crud' => true])
<div class="mx-4">
    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <thead>
        <tr>
            @foreach($fillables ? $fillables : $results[0]->getFillable() as $fillable)
                <th class="px-4 py-2 text-left">{{ ucwords(str_replace('_', ' ', join(' ', preg_split('/(?=[A-Z])/', $fillable)))) }}</th>
            @endforeach
            <th class="px-4 py-2 text-left">Created At</th>
            @if ($crud)
                <th class="px-4 py-2 text-left">Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @if ($create)
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <form wire:submit.prevent="create">
                    @foreach($fillables ? $fillables : $results[0]->getFillable() as $fillable)
                        <td class="py-2 px-4">
                            <label for="{{ $results[0]->$fillable ?? $fillable }}"></label>
                            @if (str_contains($fillable, 'date') !== false)
                                <flux:input
                                        type="date"
                                        class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                                        wire:model="form.{{ $fillable }}"
                                />
                                @error('form.' . $fillable) <span
                                        class="text-red-500">{{ str_replace('form.', '', $message) }}</span> @enderror
                            @elseif (str_contains($fillable, 'image') !== false || str_contains($fillable, 'logo') !== false)
                                <flux:input
                                        type="file"
                                        class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                                        wire:model="form.{{ $fillable }}"
                                />
                                @error('form.' . $fillable) <span
                                        class="text-red-500">{{ str_replace('form.', '', $message) }}</span> @enderror
                            @elseif (str_contains($fillable, 'time') !== false)
                                <flux:input
                                        type="datetime-local"
                                        min="'{{ date('Y-m-d\TH:i:s', strtotime(now())) }}'"
                                        class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                                        wire:model="form.{{ $fillable }}"
                                />
                            @else
                                <flux:input
                                        type="text"
                                        class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                                        wire:model="form.{{ $fillable }}"
                                />
                            @endif
                        </td>
                    @endforeach
                    <td class="py-2 px-4 grid grid-cols-2 gap-2"></td>
                    <td class="py-2 px-4">
                        <flux:button>Add</flux:button>
                    </td>
                </form>
            </tr>
        @endif
        @foreach ($results as $result)
            <tr class="{{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }}">
                @foreach ($result->getFillable() as $field)
                    <td class="py-2 px-4">
                        @if (str_contains($field, 'image') !== false || str_contains($field, 'logo') !== false)
                            <flux:avatar :src="$result->$field"/>
                        @else
                            @if (str_contains($field, '_id') !== false)
                                {{ $result->{str_replace('_id', '', $field)}->name }}
                            @else
                                {{ $result->$field }}
                            @endif
                        @endif
                    </td>
                @endforeach
                <td class="py-2 px-4">
                    {{ $result->created_at }} ({{ $result->created_at->diffForHumans() }})
                </td>
                @if ($crud)
                    <td class="py-2 px-4">
                        <div class="grid grid-cols-2 gap-2">
                            <flux:button href="{{ route($type . '.edit', $result->id) }}">Edit</flux:button>
                            <flux:button variant="danger" wire:click="delete({{ $result->id }})">Delete
                            </flux:button>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach

        @if ($results->count() == 0)
            <tr>
                <td colspan="4" class="py-2 text-center">No results found.</td>
            </tr>
        @endif
        </tbody>
    </table>

    <div class="p-4">
        @if ($results->count() > 0)
            {{ $results->links() }}
        @endif
    </div>
</div>
