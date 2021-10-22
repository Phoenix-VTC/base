{{-- Because she competes with no one, no one can compete with her. --}}

@section('title', 'Tracker information')

@section('actions')
    <div class="ml-3">
        <x-app-ui::button tag="a" href="{{ route('settings.security') }}">
            View your tracker token
        </x-app-ui::button>
    </div>
@endsection

<div>
    <x-alert/>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <x-app-ui::card>
                <x-slot name="header">
                    <x-app-ui::card.heading>
                        Setup guide
                    </x-app-ui::card.heading>
                </x-slot>

                <x-app-ui::prose>
                    <p class="font-medium">
                        When installing the tracker, please do this without having ETS2 or ATS open. Otherwise the
                        automatic installation might fail.
                    </p>

                    <ol>
                        <li>
                            Launch the <b>{{ $latestYaml['path'] ?? 'tracker setup' }}</b> file.
                        </li>

                        <li>
                            Open the Phoenix Tracker directly from the installer, or by searching for "Phoenix Tracker"
                            in Windows.
                            <img
                                src="https://tracker-resources.s3.fr-par.scw.cloud/setup_guide_resources/setup_file.png"
                                alt="Setup file screenshot">
                        </li>

                        <li>
                            After opening the tracker, an installation prompt should pop up. Press "Yes".
                            <br>
                            This will automatically try to install the telemetry SDKs for ETS2 and ATS, depending on
                            which games you have installed.
                            <img src="https://tracker-resources.s3.fr-par.scw.cloud/setup_guide_resources/sdk_setup.png"
                                 alt="SDK setup screenshot">
                        </li>

                        <li>
                            Now, head over to your <a href="{{ route('settings.security') }}" target="_blank">PhoenixBase
                                security page</a> and (re)generate a (new) tracker token.
                        </li>

                        <li>
                            Copy this token, and head back to the tracker. Now paste this in to the "Tracker token"
                            field, and press "Save".
                            <img
                                src="https://tracker-resources.s3.fr-par.scw.cloud/setup_guide_resources/enter_tracker_token.png"
                                alt="Enter tracker token screenshot">
                            If the token was pasted in correctly, you will see a success notification after saving, and
                            your profile picture should be visible in the sidebar.
                        </li>
                    </ol>

                    <p>
                        The tracker is now ready to be used! Jobs will automatically get sent over to the
                        PhoenixBase. You can also view your pending tracker jobs in the tracker itself, by clicking on
                        the truck icon in the sidebar.
                    </p>
                </x-app-ui::prose>

                @if($setupFileUrl)
                    <x-slot name="footer">
                        <x-app-ui::card.actions align="center">
                            <x-app-ui::button class="w-full" tag="a" href="{{ $setupFileUrl }}">
                                Download tracker
                            </x-app-ui::button>
                        </x-app-ui::card.actions>
                    </x-slot>
                @endif
            </x-app-ui::card>

            <x-app-ui::card>
                <x-slot name="header">
                    <x-app-ui::card.heading>
                        Frequently asked questions
                    </x-app-ui::card.heading>
                </x-slot>

                <x-app-ui::collapsible :flat="true">
                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            I've completed a delivery in-game. What now?
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                After completing a delivery in-game, you can head over to the <b>Pending Jobs</b> page
                                in the tracker, or the <b>"My Jobs"</b> > <a
                                    href="{{ route('jobs.personal-overview') }}">"Personal Overview"</a> page on the
                                PhoenixBase.
                            </p>

                            <p>
                                On those pages, you should see a new entry in the table with your recently completed job
                                with
                                the status <b>Incomplete</b> in yellow. Simply press on this job, then click on the
                                <b>Verify Job</b> button in
                                the top-right, make sure that all the information is correct, and press on <b>Verify</b>.

                                <img
                                    src="https://tracker-resources.s3.fr-par.scw.cloud/setup_guide_resources/job_show_page.png"
                                    alt="">
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>

                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            Do I need to open the tracker before starting my game?
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                No! You can open the tracker at any given time, even when you have already started the
                                job in-game.
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>

                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            The status of my job is set to "Pending Verification". What does that mean?
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                This means that a city, company or cargo used in this job doesn’t exist in the
                                PhoenixBase database yet.
                                <br>
                                It has been automatically been requested for you, and after being approved by a
                                Management member, you are able to verify this job.
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>

                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            I use map/company/cargo mods. Is this an issue?
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                Not at all! The Phoenix Tracker supports every mod. If a specific game data entry (e.g.
                                city) does not exist in our database yet, it will be automatically requested.
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>

                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            I have changed the location of my game(s) or TruckersMP. How do I fix the tracker?
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                When opening the tracker, press on "Settings" in the top navigation bar, and click on
                                "Reset installation status".
                                <br>
                                Your tracker will now restart, and you'll then see a notification about the installation
                                setup. Follow this, and it should detect your new game path(s) again.
                            </p>

                            <p>
                                <b>If the above did not help</b>, again go to "Settings" in the top navigation bar, but
                                click on "Change game paths" instead, and then the paths you want to change.
                                <br>
                                In here, manually select the game paths.
                            </p>

                            <p>
                                <b>If the above also did not help</b>, launch the Phoenix Tracker as administrator and
                                try the above steps again.
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>

                    <x-app-ui::collapsible.item :flat="true">
                        <x-slot name="heading">
                            My Discord rich presence is not working
                        </x-slot>

                        <x-app-ui::prose>
                            <p>
                                <b>If this issue only occurs while playing on TruckersMP</b>, head over to your in-game
                                tab
                                menu settings, and disable the "Discord rich presence" option.
                                <br>
                                For more information about this, see <a href="https://truckersmp.com/kb/85"
                                                                        target="_blank">TruckersMP Commands, Keybinds &
                                    Settings</a>.
                            </p>

                            <p>
                                <b>If this issue also occurs on singleplayer</b>, go to your Discord client settings,
                                click on "Activity status", and make sure the "Display current
                                activity as a status message" option is enabled.
                            </p>
                        </x-app-ui::prose>
                    </x-app-ui::collapsible.item>
                </x-app-ui::collapsible>

            </x-app-ui::card>
        </div>

        <div>
            <x-app-ui::card>
                <x-slot name="header">
                    <x-app-ui::card.heading>
                        Phoenix Tracker
                        @isset($latestYaml['version'])
                            v{{ $latestYaml['version'] }}
                        @endisset
                    </x-app-ui::card.heading>
                </x-slot>

                <x-app-ui::prose>
                    <div class="space-y-5">
                        @isset($latestYaml['version'])
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-document-text class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Most recent version:</span>
                                <span class="text-gray-900 text-sm font-bold">
                                v{{ $latestYaml['version'] }}
                            </span>
                            </div>
                        @endisset

                        @isset($latestYaml['releaseDate'])
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calendar class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Release date:</span>
                                <span class="text-gray-900 text-sm font-bold">
                                {{ Carbon\Carbon::parse($latestYaml['releaseDate'])->toFormattedDateString() }}
                            </span>
                            </div>
                        @endisset

                        @isset($latestYaml['files'][0]['size'])
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-download class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Installer file size:</span>
                                <span class="text-gray-900 text-sm font-bold">
                                {{ number_format($latestYaml['files'][0]['size'] / 1048576, 2)  }} MB
                            </span>
                            </div>
                        @endisset
                    </div>
                </x-app-ui::prose>

                <x-slot name="footer">
                    <x-app-ui::card.actions class="flex-col" :fullWidth="true">
                        @if($setupFileUrl)
                            <x-app-ui::button class="w-full" tag="a" href="{{ $setupFileUrl }}">
                                Download
                            </x-app-ui::button>
                        @endif

                        @isset($latestYaml['sha512'])
                            <x-app-ui::button size="sm" color="secondary"
                                              @click="$clipboard('{{ $latestYaml['sha512'] }}')">
                                Copy checksum
                            </x-app-ui::button>
                        @endisset
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </div>
    </div>
</div>
