@php
    if (Auth::user()->can('manage game data')) {
         $unapprovedGameDataCount = Cache::remember('unapproved_game_data_count', 300, function () {
            $unapprovedCargosCount = App\Models\Cargo::where('approved', false)->count();
            $unapprovedCitiesCount = App\Models\City::where('approved', false)->count();
            $unapprovedCompaniesCount = App\Models\Company::where('approved', false)->count();

            return $unapprovedCargosCount + $unapprovedCitiesCount + $unapprovedCompaniesCount;
        });
    }

    if(Auth::user()->can('handle driver applications')) {
        $pendingApplicationCount = Cache::remember('pending_application_count', 300, function () {
            return App\Models\Application::whereNull('claimed_by')->count();
        });
    }

    if(Auth::user()->can('manage vacation requests')) {
        $pendingVacationRequestCount = Cache::remember('vacation_request_count', 300, function () {
            return App\Models\VacationRequest::whereNull('handled_by')->count();
        });
    }
@endphp

<x-sidebar.group>
    <x-sidebar.item title="Dashboard" icon="o-home" route="dashboard"/>

    <livewire:components.dropdown title="My Jobs" icon="o-briefcase" activeRoute="jobs.*"
                                  :items="[
                                    ['title' => 'Personal Overview', 'route' => 'users.jobs-overview', 'parameters' => Auth::user()->slug],
                                    ['title' => 'Submit New Job', 'route' => 'jobs.choose-game'],
                                  ]">
    </livewire:components.dropdown>

    <x-sidebar.item title="Tracker" icon="o-location-marker" route="tracker-information"/>

    <x-sidebar.item title="Events" icon="o-calendar" route="events.home"/>

    <x-sidebar.item title="Vacation Requests" icon="o-clock" route="vacation-requests.index"
                    activeRoute="vacation-requests.*"/>

    <x-sidebar.item title="Leaderboard" icon="o-trending-up" route="leaderboard"
                    activeRoute="leaderboard"/>

    <x-sidebar.item title="Downloads" icon="o-download" route="downloads.index"
                    activeRoute="downloads.*"/>

    <x-sidebar.item title="Screenshot Hub" icon="o-photograph" route="screenshot-hub.index"
                    activeRoute="screenshot-hub.*"/>
</x-sidebar.group>

@if(Auth::user()->isStaff() || Auth::user()->isUpperStaff())
    <x-sidebar.separator title="Management"/>
@endif

<x-sidebar.group>
    @can('handle driver applications')
        <x-sidebar.item title="Recruitment" icon="o-inbox" route="recruitment.index" activeRoute="recruitment.*"
                        :unreadCount="$pendingApplicationCount ?? 0"/>
    @endcan

    @can('manage vacation requests')
        <x-sidebar.item title="Vacation Requests" icon="o-clock" route="vacation-requests.manage.index"
                        activeRoute="vacation-requests.manage.*"
                        :unreadCount="$pendingVacationRequestCount ?? 0"/>
    @endcan

    @canany(['manage users', 'manage driver inactivity', 'view blocklist'])
        <livewire:components.dropdown title="User Management" icon="o-document-search" activeRoute="user-management.*"
                                      :items="[
                                        ['title' => 'Users', 'route' => 'user-management.index', 'permission' => 'manage users'],
                                        ['title' => 'Blocklist', 'route' => 'user-management.blocklist.index', 'permission' => 'view blocklist'],
                                        ['title' => 'Driver Inactivity', 'route' => 'user-management.driver-inactivity.index', 'permission' => 'manage driver inactivity'],
                                        ['title' => 'Roles', 'route' => 'user-management.roles.index', 'permission' => 'manage users'],
                                        ['title' => 'Permissions', 'route' => 'user-management.permissions.index', 'permission' => 'manage users'],
                                      ]">
        </livewire:components.dropdown>
    @endcan

    @can('manage events')
        <x-sidebar.item title="Events" icon="o-calendar" route="event-management.index"
                        activeRoute="event-management.*"/>
    @endcan

    @can('manage downloads')
        <x-sidebar.item title="Downloads" icon="o-folder-download" route="downloads.management.index"
                        activeRoute="downloads.management.*"/>
    @endcan

    @can('manage game data')
        <livewire:components.dropdown title="Game Data" icon="o-collection" activeRoute="game-data.*"
                                      :unread-count="$unapprovedGameDataCount ?? 0"
                                      :items="[
                                        ['title' => 'Cargos', 'route' => 'game-data.cargos'],
                                        ['title' => 'Cities', 'route' => 'game-data.cities'],
                                        ['title' => 'Companies', 'route' => 'game-data.companies']
                                      ]">
        </livewire:components.dropdown>
    @endcan
</x-sidebar.group>
