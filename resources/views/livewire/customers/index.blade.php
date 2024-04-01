<div>
    <!-- HEADER -->
    <x-header title="Customers" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-primary" />
            <x-select
                wire:model.live="perPage"
                :options="
                [
                    ['id' => 5, 'name' => 5],
                    ['id' => 15, 'name' => 15],
                    ['id' => 25, 'name' => 25],
                    ['id' => 50, 'name' => 50]
                ]"
            />
            <x-button label="Customer" icon="o-plus" responsive class="btn-primary" @click="$dispatch('customer::create')"/>
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->items" with-pagination>
            @scope('header_name', $header)
            <x-table.th :$header name="name"/>
            @endscope

            @scope('header_country', $header)
            <x-table.th :$header name="country"/>
            @endscope

            @scope('header_email', $header)
            <x-table.th :$header name="email"/>
            @endscope

            @scope('cell_avatar', $item)
            <x-avatar :image="$item->avatar" class="!w-14" />
            @endscope

            @scope('cell_country', $item)
            {{ ucwords($item->country) }}
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
    <livewire:customers.create/>
</div>
