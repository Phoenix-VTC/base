<form wire:submit.prevent="submit" x-data="{formStep: 1}">
    @csrf
    <div x-show.transition.in="formStep === 1" style="">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('driver-application.steps.first.title') }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('driver-application.steps.first.subtitle') }}
                </p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="steam_username" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.default_questions.steam_username.label') }}
                        </label>
                        <input type="text" name="steam_username" id="steam_username"
                               class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md bg-gray-100"
                               value="{{ session('steam_user.personaname') }}" disabled>
                        <p class="mt-2 text-sm text-gray-500">
                            <a class="font-medium text-orange-600 hover:text-orange-500"
                               href="{{ session('steam_user.profileurl') }}" target="_blank">
                                {{ __('driver-application.default_questions.steam_username.description_link') }}
                            </a>
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="truckersmp_username" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.default_questions.truckersmp_username.label') }}
                        </label>
                        <input type="text" name="truckersmp_username" id="truckersmp_username"
                               class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md bg-gray-100"
                               value="{{ session('truckersmp_user.name') }}" disabled>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ __('driver-application.default_questions.truckersmp_username.description') }}
                            <a class="font-medium text-orange-600 hover:text-orange-500"
                               href="{{ "https://truckersmp.com/user/" . session('truckersmp_user.id') }}"
                               target="_blank">
                                {{ __('driver-application.default_questions.truckersmp_username.description_link') }}
                            </a>
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.default_questions.username') }}
                        </label>
                        <input type="text" name="username" id="username" autocomplete="username"
                               placeholder="Early Bird" wire:model.lazy="username"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('username') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('username')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500" id="username-description">
                            {{ __('driver-application.default_questions.username_description') }}
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="email"
                               class="block text-sm font-medium text-gray-700">{{ __('driver-application.default_questions.email') }}</label>
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="e.bird@gmail.com"
                               wire:model.lazy="email"
                               class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="date_of_birth"
                               class="block text-sm font-medium text-gray-700">{{ __('driver-application.default_questions.date_of_birth') }}</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" autocomplete="bday"
                               wire:model.lazy="date_of_birth"
                               class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('date_of_birth') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('date_of_birth')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="country"
                               class="block text-sm font-medium text-gray-700">{{ __('driver-application.default_questions.country') }}</label>
                        <select id="country" name="country" autocomplete="country" wire:model.lazy="country"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('country') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                            <option value="" selected
                                    disabled>{{ __('driver-application.default_questions.country_dropdown') }}</option>
                            @foreach($countries as $key => $countryName)
                                <option value="{{ $key }}">{{ $countryName }}</option>
                            @endforeach
                        </select>
                        @error('country')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-5">
                    <button @click="formStep = 2" type="button"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 cursor-pointer">
                        {{ __('buttons.continue') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show.transition.in="formStep === 2" style="">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('driver-application.steps.second.title') }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('driver-application.steps.second.subtitle') }}
                </p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-3 gap-6">
                    <fieldset class="col-span-6 sm:col-span-4">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                {{ __('driver-application.default_questions.another_vtc') }}
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="another_vtc_yes" name="another_vtc" type="radio" value="1"
                                       wire:model.lazy="another_vtc"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="another_vtc_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.yes') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="another_vtc_no" name="another_vtc" type="radio" value="0"
                                       wire:model.lazy="another_vtc"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="another_vtc_no" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.no') }}
                                </label>
                            </div>
                            @error('another_vtc')
                            <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="col-span-6 sm:col-span-4">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                {{ __('driver-application.default_questions.games') }}
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="games_ets2" name="games" type="radio" value="ets2" wire:model.lazy="games"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="games_ets2" class="ml-3 block text-sm font-medium text-gray-700">
                                    Euro Truck Simulator 2
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="games_ats" name="games" type="radio" value="ats" wire:model.lazy="games"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="games_ats" class="ml-3 block text-sm font-medium text-gray-700">
                                    American Truck Simulator
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="games_both" name="games" type="radio" value="both" wire:model.lazy="games"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="games_both" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.both') }}
                                </label>
                            </div>
                            @error('games')
                            <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="col-span-6 sm:col-span-4">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                {{ __('driver-application.default_questions.fluent') }}
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="fluent_yes" name="fluent" type="radio" value="1" wire:model.lazy="fluent"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="fluent_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.yes') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="fluent_no" name="fluent" type="radio" value="0" wire:model.lazy="fluent"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="fluent_no" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.no') }}
                                </label>
                            </div>
                            @error('fluent')
                            <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="col-span-6 sm:col-span-4" x-data="{aboutCount: 0}"
                         x-init="aboutCount = $refs.about.value.length">
                        <label for="about" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.additional_questions.about') }}
                        </label>
                        <div class="mt-1">
                            <textarea id="about" name="about" rows="3" x-ref="about"
                                      x-on:keyup="aboutCount = $refs.about.value.length" wire:model.lazy="about"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('about') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                                      placeholder="Anything will do! Tell us about your hobbies, work, favorite truck, games.."></textarea>
                            <p class="mt-2 text-sm text-gray-500" x-show.transition.in.out="aboutCount > 0" x-cloak>
                                <span x-html="aboutCount"></span> {{ __('slugs.characters') }}
                            </p>
                        </div>
                        @error('about')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-4" x-data="{whyJoinCount: 0}"
                         x-init="whyJoinCount = $refs.why_join.value.length">
                        <label for="why_join" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.additional_questions.why_join') }}
                        </label>
                        <div class="mt-1">
                            <textarea id="why_join" name="why_join" rows="3" x-ref="why_join"
                                      x-on:keyup="whyJoinCount = $refs.why_join.value.length" wire:model.lazy="why_join"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('why_join') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                                      placeholder="Nothing is too much! We don't mind reading :)"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500" x-show.transition.in.out="whyJoinCount > 0" x-cloak>
                            <span x-html="whyJoinCount"></span> {{ __('slugs.characters') }}
                        </p>
                        @error('why_join')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <fieldset class="col-span-6 sm:col-span-4">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                {{ __('driver-application.default_questions.terms') }}
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="terms_yes" name="terms" type="radio" value="1" wire:model.lazy="terms"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="terms_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.yes') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="terms_no" name="terms" type="radio" value="0" wire:model.lazy="terms"
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                <label for="terms_no" class="ml-3 block text-sm font-medium text-gray-700">
                                    {{ __('options.no') }}
                                </label>
                            </div>
                            @error('terms')
                            <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="col-span-6 sm:col-span-4" x-data="{findUsCount: 0}"
                         x-init="findUsCount = $refs.find_us.value.length">
                        <label for="find_us" class="block text-sm font-medium text-gray-700">
                            {{ __('driver-application.default_questions.find_us') }}
                        </label>
                        <div class="mt-1">
                            <textarea id="find_us" name="find_us" x-ref="find_us"
                                      x-on:keyup="findUsCount = $refs.find_us.value.length" wire:model.lazy="find_us"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('find_us') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                                      placeholder="TruckersMP, Discord advertisements, TruckersFM, etc"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500" x-show.transition.in.out="findUsCount > 0" x-cloak>
                            <span x-html="findUsCount"></span> {{ __('slugs.characters') }}
                        </p>
                        @error('find_us')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-5">
                    <button @click="formStep = 1" type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 cursor-pointer">
                        {{ __('buttons.back') }}
                    </button>
                    <button @click="formStep = 3" type="button"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        {{ __('buttons.continue') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show.transition.in="formStep === 3" style="">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('driver-application.steps.third.title') }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            {{ __('driver-application.steps.third.subtitle') }}
        </p>
        <div class="mt-5 border-t border-gray-200">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.steam_username.label') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ session('steam_user.personaname') }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.truckersmp_username.label') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ session('truckersmp_user.name') }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.username') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $username }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.email') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $email }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.date_of_birth') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $date_of_birth }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.country') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $country }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.another_vtc') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $another_vtc ? __('options.yes') : __('options.no') }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.games') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($games === 'both')
                            {{ ucfirst($games) }}
                        @else
                            {{ strtoupper($games) }}
                        @endif
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.fluent') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $fluent ? __('options.yes') : __('options.no') }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.additional_questions.about') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $about }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.additional_questions.why_join') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $why_join }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.terms') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $terms ? __('options.yes') : __('options.no') }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('driver-application.default_questions.find_us') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $find_us }}
                    </dd>
                </div>
            </dl>
            <div class="flex justify-end mt-5">
                <button @click="formStep = 2" type="button"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 cursor-pointer">
                    {{ __('buttons.back') }}
                </button>
                <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                    {{ __('buttons.apply') }}
                </button>
            </div>
        </div>

    </div>
</form>
