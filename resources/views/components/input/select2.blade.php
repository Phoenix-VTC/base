{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@props([
    'url' => '',
    'placeholder' => null,
    'selected' => [],
    'multiple' => false,
    'tags' => false,
])

@php
    $id = random_int(1,1000000)
@endphp

@once
    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.full.min.js"></script>

        @if(!$multiple)
            <style>
                .select2-selection__rendered {
                    line-height: 36px !important;
                }

                .select2-selection, .select2-selection__arrow {
                    height: 36px !important;
                }
            </style>
        @endif
    @endpush
@endonce

<div class="flex mt-1" wire:ignore>
    <select
        class="form-select block w-full h-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:ring-blue focus:border-blue-300 sm:text-sm sm:leading-5 select2-{{ $id }}"
        @if($multiple) multiple="multiple" @endif {{ $attributes }}>
        @if(!empty($selected))
            @foreach($selected as $value)
                <option value="{{ $value }}" selected="selected">{{ $value }}</option>
            @endforeach
        @endif
    </select>

    <script>
        $(document).ready(function () {
            $('.select2-{{ $id }}').select2({
                @if($url)
                ajax: {
                    url: '{{ $url }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (params.page * 10) < data.total
                            }
                        };
                    }
                },
                @endif
                placeholder: '{{ $placeholder }}',
                tags: '{{ $tags }}',
                @if($multiple && $tags && !$url)
                language: {
                    noResults: function () {
                        return 'Enter a new value to add it.';
                    },
                },
                @endif
            });

            $('.select2-{{ $id }}').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.
                set(elementName, data);
            });

            // Auto-focus non-multi search field on open. Multi selects already auto-focus for some reason, and this code will break it.
            @if(!$multiple)
            $(document).on('select2:open', () => {
                setTimeout(function () {
                    document.querySelector('.select2-search__field').focus();
                }, 10);
            });
            @endif

            // Open next dropdown on tab press
            $(document).on('focus', '.select2.select2-container', function (e) {
                // only open on original attempt - close focus event should not fire open
                if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
                    $(this).siblings('select').select2('open');
                }
            });
        });
    </script>
</div>
