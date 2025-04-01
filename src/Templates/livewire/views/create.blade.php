<div class="create flex flex-col p-4">
    <form wire:submit.prevent="create" class="space-y-4">
        @foreach($fillables as $fillable)
            <div class="flex flex-col space-y-1">
                <flux:label for="{{ $results[0]->$fillable ?? $fillable }}" class="text-lg font-semibold text-gray-700 dark:text-white">
                    {{ ucfirst($fillable) }}
                </flux:label>
                <flux:input
                        type="text"
                        wire:model="form.{{ $fillable }}"
                />
            </div>
        @endforeach
        <flux:button variant="primary" type="submit" class="mt-4 py-2 px-4">
            Create
        </flux:button>
    </form>
</div>
