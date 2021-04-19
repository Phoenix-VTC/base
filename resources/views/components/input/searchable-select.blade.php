{{-- Stop trying to control. --}}

@props([
    'data' => [],
    'placeholder' => 'Select an option',
    'limit' => 40,
])

<div
    x-data="AlpineSelect({
        data: {{ json_encode($data) }},
        selected:  @entangle($attributes->wire('model')),
        placeholder: '{{ $placeholder }}',
        multiple: {{ isset($attributes['multiple']) ? 'true':'false' }},
        disabled: {{ isset($attributes['disabled']) ? 'true':'false' }},
        limit: {{ $limit }},
    })"
    x-init="init()"
    @click.away="closeSelect()"
    @keydown.escape="closeSelect()"
    @keydown.arrow-down.prevent="increaseIndex()"
    @keydown.arrow-up.prevent="decreaseIndex()"
    @keydown.enter="selectOption(Object.keys(options)[currentIndex])"
>

    <button
        class="rounded-md border content-center p-1 bg-white relative sm:text-sm sm:leading-5 w-full text-left"
        @click.prevent="toggleSelect()"
    >
        <div id="placeholder">
            <div class="m-1 inline-block" x-show="selected.length === 0" x-text="placeholder">&nbsp;</div>
        </div>
        @isset($attributes['multiple'])
            <div class="flex flex-wrap space-x-1" x-cloak x-show="selected.length > 0">
                <template x-for="(key, index) in selected" :key="index">
                    <div
                        class="inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 my-1 text-sm font-medium bg-red-100 text-red-700">
                        <span class="truncate" x-text="data[key]"></span>
                        <button
                            x-show="!disabled" x-bind:class="{'cursor-pointer':!disabled}"
                            @click.prevent.stop="deselectOption(index)" type="button"
                            class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-red-400 hover:bg-red-200 hover:text-red-500 focus:outline-none">
                            <span class="sr-only">Remove option</span>
                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        @else
            <div class="flex flex-wrap space-x-1" x-cloak x-show="selected.length > 0">
                <template x-for="(key, index) in selected" :key="index">
                    <div
                        class="inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 my-1 text-sm font-medium bg-red-100 text-red-700">
                        <span class="truncate" x-text="data[selected]"></span>
                        <button
                            x-show="!disabled" x-bind:class="{'cursor-pointer':!disabled}"
                            @click.prevent.stop="deselectOption(index)" type="button"
                            class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-red-400 hover:bg-red-200 hover:text-red-500 focus:outline-none">
                            <span class="sr-only">Remove option</span>
                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        @endif

        <div
            class="mt-0.5 w-full bg-white border-gray-300 rounded-b-md border absolute top-full left-0 z-30"
            x-show="open"
            x-cloak>

            <div class="bg-white p-2 w-full relative z-30">
                <input
                    type="search" x-model="search" x-on:click.prevent.stop="open=true"
                    placeholder="Start typing for more results"
                    class="block w-full p-2 border border-gray-300 placeholder-gray-400 rounded-md sm:text-sm sm:leading-5">
            </div>

            <div
                class="absolute z-10 w-full bg-white shadow-lg max-h-60 rounded-b-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                tabindex="-1" role="listbox" x-ref="dropdown">
                <div class="text-gray-900 cursor-default select-none relative py-2 pl-8 pr-4" x-cloak
                     x-show="Object.keys(options).length === 0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-1.5">
                        <x-heroicon-o-x class="h-5 w-5"/>
                    </span>

                    <span class="font-semibold block truncate" x-text="emptyOptionsMessage"></span>
                </div>

                <template x-for="(key, index) in Object.keys(options)" :key="index">
                    <div
                        class="group cursor-default select-none relative py-2 pl-3 pr-4 text-gray-900 hover:bg-red-600 hover:text-white"
                        x-bind:class="{'pl-8':selected.includes(key)}"
                        role="option" @click.prevent.stop="selectOption(key)">
                        <div class="w-full inline-flex truncate capitalize">
                            <span class="truncate" x-text="Object.values(options)[index]"></span>

                            <span
                                class="text-red-600 group-hover:text-red-200 absolute inset-y-0 left-0 flex items-center pl-1.5"
                                x-show="selected.includes(key)">
                                <x-heroicon-s-check class="h-5 w-5"/>
                            </span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </button>
</div>

@once
    <script>
        function AlpineSelect(config) {
            return {
                data: config.data ?? [],
                open: false,
                search: '',
                options: {},
                emptyOptionsMessage: 'No results match your search.',
                placeholder: config.placeholder,
                selected: config.selected,
                multiple: config.multiple,
                currentIndex: 0,
                isLoading: false,
                disabled: config.disabled ?? false,
                limit: config.limit ?? 40,
                init: function () {
                    if (this.selected == null) {
                        if (this.multiple)
                            this.selected = []
                        else
                            this.selected = ''
                    }
                    if (!this.data) this.data = {}
                    this.resetOptions()
                    this.$watch('search', ((values) => {
                        if (!this.open || !values) {
                            this.resetOptions()
                            return
                        }
                        this.options = Object.keys(this.data)
                            .filter((key) => this.data[key].toLowerCase().includes(values.toLowerCase()))
                            .slice(0, this.limit)
                            .reduce((options, key) => {
                                options[key] = this.data[key]
                                return options
                            }, {})
                        this.currentIndex = 0
                    }))
                },
                resetOptions: function () {
                    this.options = Object.keys(this.data)
                        .slice(0, this.limit)
                        .reduce((options, key) => {
                            options[key] = this.data[key]
                            return options
                        }, {})
                },
                closeSelect: function () {
                    this.open = false
                    this.search = ''
                },
                toggleSelect: function () {
                    if (!this.disabled) {
                        if (this.open) return this.closeSelect()
                        this.open = true
                    }
                },
                deselectOption: function (index) {
                    if (this.multiple) {
                        this.selected.splice(index, 1)
                    } else {
                        this.selected = ''
                    }
                },
                selectOption: function (value) {
                    if (!this.disabled) {
                        // If multiple push to the array, if not, keep that value and close menu
                        if (this.multiple) {
                            // If it's not already in there
                            if (!this.selected.includes(value)) {
                                this.selected.push(value)
                            }
                        } else {
                            this.selected = value
                            this.closeSelect()
                        }
                    }
                },
                increaseIndex: function () {
                    if (this.currentIndex === Object.keys(this.options).length)
                        this.currentIndex = 0
                    else
                        this.currentIndex++
                },
                decreaseIndex: function () {
                    if (this.currentIndex === 0)
                        this.currentIndex = Object.keys(this.options).length - 1
                    else
                        this.currentIndex--;
                },
            }
        }
    </script>

@endonce
