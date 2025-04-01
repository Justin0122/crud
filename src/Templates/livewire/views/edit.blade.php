<div class="edit flex flex-col p-4">
    <form wire:submit.prevent="update" class="space-y-4">
        @foreach($fillables as $fillable)
            <div class="flex flex-col space-y-1">
                <flux:label for="{{ $results->$fillable }}" class="text-sm font-semibold text-gray-600">
                    {{ ucfirst($fillable) }}
                </flux:label>
                <flux:input
                        type="text"
                        placeholder="{{ $results->$fillable }}"
                        wire:model="form.{{ $fillable }}"
                />
            </div>
        @endforeach
        <flux:button variant="primary" type="submit" class="mt-4 py-2 px-4">
            Submit
        </flux:button>
    </form>
    <flux:button variant="danger" wire:click="delete({{ $results->id }})" class="mt-4 py-2 px-4">
        Delete
    </flux:button>
</div>
