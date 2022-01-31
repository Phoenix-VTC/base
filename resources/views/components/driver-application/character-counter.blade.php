<p class="mt-2 text-sm text-gray-500"
   :class="min ? (count >= min ? 'text-green-500' : 'text-red-500') : null"
   x-show.transition.in.out="count > 0"
   x-cloak>
    <span x-html="count"></span>
    <span x-show="typeof min !== 'undefined'">
        /
        <span x-html="min"></span>
    </span>
    {{ __('slugs.characters') }}
</p>
