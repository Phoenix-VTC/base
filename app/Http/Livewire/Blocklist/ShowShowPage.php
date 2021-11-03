<?php

namespace App\Http\Livewire\Blocklist;

use App\Events\BlocklistEntryDeleted;
use App\Events\BlocklistEntryRestored;
use App\Models\Blocklist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowShowPage extends Component
{
    use AuthorizesRequests;

    public Blocklist $blocklist;

    public function mount(int $id): void
    {
        $this->blocklist = Blocklist::withTrashed()->findOrFail($id);

        $this->authorize('view', $this->blocklist);
    }

    public function render()
    {
        return view('livewire.blocklist.show-page')->extends('layouts.app');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->blocklist);

        event(new BlocklistEntryDeleted($this->blocklist));

        $this->blocklist->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry deleted successfully!']);
    }

    public function restore(): void
    {
        $this->authorize('restore', $this->blocklist);

        $this->blocklist->restore();

        event(new BlocklistEntryRestored($this->blocklist));

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry restored successfully!']);
    }
}
