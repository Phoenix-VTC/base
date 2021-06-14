<x-sidebar.group>
    <x-sidebar.item title="Dashboard" icon="o-home" route="dashboard"/>

    @can('submit jobs')
        <livewire:components.dropdown title="My Jobs" icon="o-briefcase" activeRoute="jobs.*"
                                      :items="[
                                        ['title' => 'Personal Overview', 'route' => 'jobs.personal-overview'],
                                        ['title' => 'Submit New Job', 'route' => 'jobs.choose-game'],
                                      ]">
        </livewire:components.dropdown>
    @endcan

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

@hasanyrole('super admin|management|human resources|recruitment|community interactions|events|media|modding')
    <x-sidebar.separator title="Management"/>
@endhasanyrole

<x-sidebar.group>
    @can('handle driver applications')
        <x-sidebar.item title="Recruitment" icon="o-inbox" route="recruitment.index" activeRoute="recruitment.*"/>
    @endcan

    @can('manage vacation requests')
        <x-sidebar.item title="Vacation Requests" icon="o-clock" route="vacation-requests.manage.index"
                        activeRoute="vacation-requests.manage.*"/>
    @endcan

    @canany(['manage users', 'manage driver inactivity'])
            <livewire:components.dropdown title="User Management" icon="o-document-search" activeRoute="user-management.*"
                                          :items="[
                                        ['title' => 'Users', 'route' => 'user-management.index'],
                                        ['title' => 'Driver Inactivity', 'route' => 'user-management.driver-inactivity.index'],
                                        ['title' => 'Roles', 'route' => 'user-management.roles.index'],
                                        ['title' => 'Permissions', 'route' => 'user-management.permissions.index'],
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
                                      :items="[
                                        ['title' => 'Cargos', 'route' => 'game-data.cargos'],
                                        ['title' => 'Cities', 'route' => 'game-data.cities'],
                                        ['title' => 'Companies', 'route' => 'game-data.companies']
                                      ]">
        </livewire:components.dropdown>
    @endcan
</x-sidebar.group>
