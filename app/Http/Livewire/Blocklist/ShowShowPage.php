<?php

namespace App\Http\Livewire\Blocklist;

use App\Models\Blocklist;
use Livewire\Component;

class ShowShowPage extends Component
{
    public Blocklist $blocklist;

    public function mount(int $id): void
    {
        $this->blocklist = Blocklist::withTrashed()->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.blocklist.show-page')->extends('layouts.app');
    }

    public function delete(): void
    {
        $this->blocklist->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry deleted successfully!']);
    }

    public function restore(): void
    {
        $this->blocklist->restore();

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry restored successfully!']);
    }
}
