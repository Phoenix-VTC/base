@props(['initialValue' => ''])

<div
    wire:ignore
    {{ $attributes->merge(['class' => 'rounded-md shadow-sm']) }}
    x-data
    @trix-blur="$dispatch('change', $event.target.value)"
>
    <input id="x" value="{{ $initialValue }}" type="hidden">
    <trix-editor input="x"
                 class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 prose max-w-none"></trix-editor>
    <script>
        Trix.config.attachments.preview.caption = {
            name: false,
            size: false
        }

        document.addEventListener("trix-file-accept", function (event) {
            let mimeTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

            if (! mimeTypes.includes(event.file.type) ) {
                return event.preventDefault();
            }
        });
    </script>
</div>
