{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@props([
    'url' => '',
    'placeholder' => null,
    'selected' => [],
])

@once
    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.full.min.js"></script>

        <style>
            .select2-selection__rendered {
                line-height: 36px !important;
            }

            .select2-selection, .select2-selection__arrow {
                height: 36px !important;
            }
        </style>
    @endpush
@endonce

<div class="flex mt-1" wire:ignore>
    <select
        class="form-select block w-full h-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:ring-blue focus:border-blue-300 sm:text-sm sm:leading-5 select2-{{ $attributes['id'] }}" {{ $attributes }}>
        @if(!empty($selected))
            <option value="{{ key($selected) }}" selected="selected">{{ current($selected) }}</option>
        @endif
    </select>

    <script>
        $(document).ready(function () {
            $('.select2-{{ $attributes['id'] }}').select2({
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
                placeholder: '{{ $placeholder }}',
            });
            $('.select2-{{ $attributes['id'] }}').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
            @this.set(elementName, data);
            });
            $(document).on('select2:open', () => {
                setTimeout(function () {
                    document.querySelector('.select2-search__field').focus();
                }, 10);
            });

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
