<?php

namespace App\Http\Livewire\Blocklist;

use App\Events\BlocklistEntryUpdated;
use App\Models\Blocklist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowEditPage extends Component
{
    use AuthorizesRequests;

    public Blocklist $blocklist;

    public ?array $usernames = [];

    public ?array $emails = [];

    public ?array $discord_ids = [];

    public ?array $truckersmp_ids = [];

    public ?array $steam_ids = [];

    public ?array $base_ids = [];

    public string $reason = '';

    public function rules(): array
    {
        return [
            'usernames' => ['present', 'array', 'required_without_all:emails,discord_ids,truckersmp_ids,steam_ids,base_ids,base_or_recruitment_id'],
            'emails' => ['present', 'array', 'required_without_all:usernames,discord_ids,truckersmp_ids,steam_ids,base_ids,base_or_recruitment_id'],
            'discord_ids' => ['present', 'array', 'required_without_all:usernames,emails,truckersmp_ids,steam_ids,base_ids,base_or_recruitment_id'],
            'truckersmp_ids' => ['present', 'array', 'required_without_all:usernames,emails,discord_ids,steam_ids,base_ids,base_or_recruitment_id'],
            'steam_ids' => ['present', 'array', 'required_without_all:usernames,emails,discord_ids,truckersmp_ids,base_ids,base_or_recruitment_id'],
            'base_ids' => ['present', 'array', 'required_without_all:usernames,emails,discord_ids,truckersmp_ids,base_or_recruitment_id'],
            'reason' => ['required', 'string'],
        ];
    }

    protected array $validationAttributes = [
        'discord_ids' => 'Discord IDs',
        'truckersmp_ids' => 'TruckersMP IDs',
        'steam_ids' => 'SteamID64 IDs',
        'base_ids' => 'PhoenixBase IDs',
    ];

    public function mount()
    {
        $this->authorize('update', $this->blocklist);

        $this->fill([
            'usernames' => $this->blocklist->usernames,
            'emails' => $this->blocklist->emails,
            'discord_ids' => $this->blocklist->discord_ids,
            'truckersmp_ids' => $this->blocklist->truckersmp_ids,
            'steam_ids' => $this->blocklist->steam_ids,
            'base_ids' => $this->blocklist->base_ids,
            'reason' => $this->blocklist->reason,
        ]);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.blocklist.edit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $blocklist = $this->blocklist;

        $blocklist->usernames = $validatedData['usernames'];
        $blocklist->emails = $validatedData['emails'];
        $blocklist->discord_ids = $validatedData['discord_ids'];
        $blocklist->truckersmp_ids = $validatedData['truckersmp_ids'];
        $blocklist->steam_ids = $validatedData['steam_ids'];
        $blocklist->base_ids = $validatedData['base_ids'];

        $blocklist->reason = $validatedData['reason'];

        $blocklist->save();

        event(new BlocklistEntryUpdated($blocklist));

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry updated successfully!']);

        return redirect()->route('user-management.blocklist.show', $blocklist->id);
    }
}
