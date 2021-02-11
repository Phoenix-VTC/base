{{-- If your happiness depends on money, you will never be happy with yourself. --}}

<div class="relative bg-gray-900">
    <div class="relative h-56 bg-indigo-600 sm:h-72 md:absolute md:left-0 md:h-full md:w-1/2">
        <img class="w-full h-full object-cover"
             src="https://phoenixvtc.com/img/9d317252-3439-41ca-aba8-368f6b668d24/ets2-20210113-201532-00.png"
             alt="">
        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-r from-gray-900 to-red-400"
             style="mix-blend-mode: multiply;"></div>
    </div>
    <div
        class="relative mx-auto max-w-md px-4 py-12 sm:max-w-7xl sm:px-6 sm:py-20 md:py-28 lg:px-8 lg:py-32">
        <div class="md:ml-auto md:w-1/2 md:pl-10">
            <h2 class="text-base font-semibold uppercase tracking-wider text-orange-600">
                {{ $tag }}
            </h2>
            <p class="mt-2 text-white text-3xl font-extrabold tracking-tight sm:text-4xl">
                {{ $title }}
            </p>
            <p class="mt-3 text-lg text-gray-300">
                {{ $description }}
            </p>
            @if($buttonText)
                <div class="mt-8">
                    <a href="{{ $buttonUrl ?? '#' }}"
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-50">
                        {{ $buttonText }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
