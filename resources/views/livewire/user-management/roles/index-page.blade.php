{{-- The Master doesn't talk, he acts. --}}

@section('title', 'Role Management')

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 space-y-6">
                @empty(!$roles->count())
                    @foreach($roles as $role)
                        <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow">

                            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="leading-6 font-medium pb-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5" style="background-color: {{ $role->badge_color }}; color: {{ $role->text_color }}">
                                        {{ ucwords($role->name) }}
                                    </span>
                                </h3>
                                <div class="mt-1 flex flex-row divide-x space-x-3 text-sm text-gray-500">
                                    <div>
                                        ID: <code>{{ $role->id }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Level: <code>{{ $role->level }}</code>
                                        @if($role->level === 1)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Minimum
                                            </span>
                                        @endif

                                        @if($role->level === 255)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Maximum
                                            </span>
                                        @endif
                                    </div>

                                    <div class="pl-3">
                                        Real Name: <code>{{ $role->name }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Guard Name: <code>{{ $role->guard_name }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Created At: <code>{{ $role->created_at }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Updated at: <code>{{ $role->updated_at }}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-5 space-y-5">
                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">
                                        Users with this role
                                        <small>({{ $role->users->count() }})</small>
                                    </h2>
                                    <div class="flex flex-col mt-3">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <div
                                                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                ID
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Username
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Email
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Created At
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @empty(!$role->users->count())
                                                            @foreach($role->users as $user)
                                                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $user->id }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                        {{ $user->username }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $user->email }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $user->created_at }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                There aren't any active users in this role.
                                                            </td>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">
                                        Permissions
                                        <small>({{ $role->permissions->count() }})</small>
                                    </h2>
                                    <div class="flex flex-col mt-3">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <div
                                                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                ID
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Name
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Guard Name
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Created At
                                                            </th>

                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Updated At
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @empty(!$role->permissions->count())
                                                            @foreach($role->permissions as $permission)
                                                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $permission->id }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                        {{ $permission->name }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $permission->guard_name }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $permission->created_at }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $permission->updated_at }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                This role doesn't have any permissions.
                                                            </td>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <x-empty-state :image="asset('img/illustrations/no_data.svg')"
                                   alt="No data illustration">
                        Hmm, it looks like there aren't any roles yet.
                        <br><br>
                        This is fine. 🔥 ☕
                        <br>
                        But you should probably notify the Development Team.
                    </x-empty-state>
                @endif
            </div>
        </div>
    </div>
</div>
