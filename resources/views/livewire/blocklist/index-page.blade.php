{{-- The best athlete wants his opponent at his best. --}}

@section('title', 'Blocklist Entries')

@section('actions')
    @if(Auth::user()->can('create blocklist'))
        <div class="ml-3">
            <a href="{{ route('user-management.blocklist.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                New blocklist entry
            </a>
        </div>
    @endif
@endsection

<div>
    <livewire:blocklist.blocklist-table/>
</div>
