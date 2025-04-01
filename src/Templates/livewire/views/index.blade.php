<div class="container mx-auto px-4">
    @if($this->id)
        {{ __('Edit') }}
        {{ $this->id }}
        @include('livewire.crud.edit')
    @else
        {{ __('Create') }}
        @include('livewire.crud.create')

        {{ $results->links() }}

        <div class="flex">
            <x-table :results="$results" :type="" :crud="true" :fillables="$fillables"/>
        </div>
    @endif
</div>
