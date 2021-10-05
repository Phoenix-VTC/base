<?php

namespace App\Http\Livewire\Blocklist;

use App\Models\Application;
use App\Models\Blocklist;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Livewire\Component;

class ShowCreatePage extends Component
{
    public string $base_or_recruitment_id = '';
    public ?Application $driverApplication = null;
    public ?User $user = null;
    public array $usernames = [];
    public array $emails = [];
    public array $discord_ids = [];
    public array $truckersmp_ids = [];
    public array $steam_ids = [];
    public array $base_ids = [];
    public string $reason = '';

    public function rules(): array
    {
        return [
            'base_or_recruitment_id' => ['present', 'string', 'required_without_all:usernames,emails,discord_ids,truckersmp_ids,base_ids'],
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
        'base_or_recruitment_id' => 'PhoenixBase ID or Driver Application ID',
        'discord_ids' => 'Discord IDs',
        'truckersmp_ids' => 'TruckersMP IDs',
        'steam_ids' => 'SteamID64 IDs',
        'base_ids' => 'PhoenixBase IDs',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        if ($this->base_or_recruitment_id) {
            // Unset the chosen user and driverApplication on base_or_recruitment_id change
            unset($this->user, $this->driverApplication);

            // Reset manual input fields on base_or_recruitment_id change
            $this->reset([
                'usernames',
                'emails',
                'discord_ids',
                'truckersmp_ids',
                'steam_ids',
                'base_ids'
            ]);

            $this->validateBaseOrRecruitmentId();
        }
    }

    public function render()
    {
        return view('livewire.blocklist.create-page')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $blocklist = new Blocklist;

        if ($this->base_or_recruitment_id && $this->user) {
            $user = $this->user;

            $blocklist->usernames = [$user->username];
            $blocklist->emails = [$user->email];
            if ($user->discord) {
                $blocklist->discord_ids = [$user->discord['id']];
            }
            $blocklist->truckersmp_ids = [$user->truckersmp_id];
            $blocklist->steam_ids = [$user->steam_id];
            $blocklist->base_ids = [$user->id];
        } elseif ($this->base_or_recruitment_id && $this->driverApplication) {
            $driverApplication = $this->driverApplication;

            $blocklist->usernames = [$driverApplication->username];
            $blocklist->emails = [$driverApplication->email];
            $blocklist->truckersmp_ids = [$driverApplication->truckersmp_id];
            $blocklist->steam_ids = [$driverApplication->steam_data['steamID64']];
        } else {
            $blocklist->usernames = $validatedData['usernames'];
            $blocklist->emails = $validatedData['emails'];
            $blocklist->discord_ids = $validatedData['discord_ids'];
            $blocklist->truckersmp_ids = $validatedData['truckersmp_ids'];
            $blocklist->steam_ids = $validatedData['steam_ids'];
            $blocklist->base_ids = $validatedData['base_ids'];
        }

        $blocklist->reason = $validatedData['reason'];

        $blocklist->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry added successfully!']);

        return redirect()->route('user-management.blocklist.show', $blocklist->id);
    }

    private function validateBaseOrRecruitmentId()
    {
        // If the base_or_recruitment_id is a UUID, try to find the driver application
        if (Str::isUuid($this->base_or_recruitment_id)) {
            try {
                $this->driverApplication = Application::query()->where('uuid', $this->base_or_recruitment_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $this->addError('base_or_recruitment_id', 'Invalid Driver Application ID');

                return;
            }

            return;
        }

        // If the base_or_recruitment_id is numeric, try to find the user
        if (is_numeric($this->base_or_recruitment_id)) {
            try {
                $this->user = User::query()->withTrashed()->findOrFail($this->base_or_recruitment_id);
            } catch (ModelNotFoundException $e) {
                $this->addError('base_or_recruitment_id', 'Invalid User ID');

                return;
            }

            // Check if user is deleted
            if (!$this->user->deleted_at) {
                $this->addError('base_or_recruitment_id', 'The chosen user is not deleted yet, therefore you cannot blocklist them.');
            }

            return;
        }

        $this->addError('base_or_recruitment_id', 'Invalid PhoenixBase ID or Driver Application ID');
    }
}
