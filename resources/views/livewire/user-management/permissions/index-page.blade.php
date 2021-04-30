{{-- The Master doesn't talk, he acts. --}}

@section('title', 'Permission Management')

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 space-y-6">
                @empty(!$permissions->count())
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">
                            Permissions
                            <small>({{ $permissions->count() }})</small>
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
                                            @foreach($permissions->sortBy('name') as $permission)
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    @foreach($permissions as $permission)
                        <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow">

                            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ ucwords($permission->name) }}
                                </h3>
                                <div class="mt-1 flex flex-row divide-x space-x-3 text-sm text-gray-500">
                                    <div>
                                        ID: <code>{{ $permission->id }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Real Name: <code>{{ $permission->name }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Guard Name: <code>{{ $permission->guard_name }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Created At: <code>{{ $permission->created_at }}</code>
                                    </div>

                                    <div class="pl-3">
                                        Updated at: <code>{{ $permission->updated_at }}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-5 space-y-5">
                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">
                                        Users with this permission
                                        <small>({{ $permission->users->count() }})</small>
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
                                                        @empty(!$permission->users->count())
                                                            @foreach($permission->users as $user)
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
                                                                There aren't any active users with this permission.
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
                                        Roles
                                        <small>({{ $permission->roles->count() }})</small>
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
                                                        @empty(!$permission->roles->count())
                                                            @foreach($permission->roles as $role)
                                                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $role->id }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                        {{ $role->name }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $role->guard_name }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $role->created_at }}
                                                                    </td>

                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $role->updated_at }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                This permission doesn't have any roles.
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
