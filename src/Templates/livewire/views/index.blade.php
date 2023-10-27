<div class="container mx-auto px-4">
    @if($this->id)
        {{ __('Edit') }}
        @include('livewire.crud.edit')
    @else
        {{ __('Create') }}
        @include('livewire.crud.create')

        {{ $results->links() }}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-40">
            @foreach($results as $result)
                @php
                    $attributes = $result->getAttributes();
                    $title = $attributes[array_keys($attributes)[1]];
                    $body = $attributes[array_keys($attributes)[2]];
                @endphp
                <x-card
                    :title="$title ?? ''"
                    :title-classes="'text-2xl'"
                    :description="Str::limit($body, 100) . '' ?? ''"
                    :image="$result->image ?? 'https://placehold.co/1200x1200'"
                    :button="['url' => url()->current() . '?id=' . $result->id, 'label' => 'View'] ?? ''"
                    :deleteButton="['id' => $result->id] ?? ''"
                />
            @endforeach

        </div>
    @endif
</div>
