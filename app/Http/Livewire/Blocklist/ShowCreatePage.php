<?php

namespace App\Http\Livewire\Blocklist;

use App\Events\NewBlocklistEntry;
use App\Models\Application;
use App\Models\Blocklist;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class ShowCreatePage extends Component
{
    use AuthorizesRequests;

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

    public function mount(): void
    {
        $this->authorize('create', Blocklist::class);
    }

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
            // If the blocklist entry is a chosen user
            $user = $this->user;

            $blocklist->usernames = [(string)$user->username];
            $blocklist->emails = [(string)$user->email];
            if ($user->discord) {
                $blocklist->discord_ids = [(string)$user->discord['id']];
            }
            $blocklist->truckersmp_ids = [(string)$user->truckersmp_id];
            $blocklist->steam_ids = [(string)$user->steam_id];
            $blocklist->base_ids = [(string)$user->id];
        } elseif ($this->base_or_recruitment_id && $this->driverApplication) {
            // If the blocklist entry is a chosen driver application
            $driverApplication = $this->driverApplication;

            $blocklist->usernames = [(string)$driverApplication->username];
            $blocklist->emails = [(string)$driverApplication->email];
            $blocklist->truckersmp_ids = [(string)$driverApplication->truckersmp_id];
            $blocklist->steam_ids = [(string)$driverApplication->steam_data['steamID64']];
        } else {
            // If the blocklist entry is manual
            $blocklist->usernames = $validatedData['usernames'];
            $blocklist->emails = $validatedData['emails'];
            $blocklist->discord_ids = $validatedData['discord_ids'];
            $blocklist->truckersmp_ids = $validatedData['truckersmp_ids'];
            $blocklist->steam_ids = $validatedData['steam_ids'];
            $blocklist->base_ids = $validatedData['base_ids'];
        }

        $blocklist->reason = $validatedData['reason'];

        $blocklist->save();

        event(new NewBlocklistEntry($blocklist));

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry added successfully!']);

        return redirect()->route('user-management.blocklist.show', $blocklist->id);
    }

    private function validateBaseOrRecruitmentId(): void
    {
        // If the base_or_recruitment_id is a UUID, try to find the driver application
        if (Str::isUuid($this->base_or_recruitment_id)) {
            try {
                $this->driverApplication = Application::query()->where('uuid', $this->base_or_recruitment_id)->firstOrFail();
            } catch (ModelNotFoundException) {
                $this->addError('base_or_recruitment_id', 'Invalid Driver Application ID');

                return;
            }

            // Check if application is completed
            if (!$this->driverApplication->is_completed) {
                $this->addError('base_or_recruitment_id', 'The chosen driver application is not completed yet. If you want to blocklist them, do this via the recruitment system instead.');
            }

            return;
        }

        // If the base_or_recruitment_id is numeric, try to find the user
        if (is_numeric($this->base_or_recruitment_id)) {
            try {
                $this->user = User::query()->withTrashed()->findOrFail($this->base_or_recruitment_id);
            } catch (ModelNotFoundException) {
                $this->addError('base_or_recruitment_id', 'Invalid User ID');

                return;
            }

            // Check if user is deleted
            if (!$this->user->deleted_at) {
                $this->addError('base_or_recruitment_id', 'The chosen user is not deleted yet, therefore you cannot blocklist them.');
            }

            return;
        }

        // If the validation reaches this, add an invalid error message.
        $this->addError('base_or_recruitment_id', 'Invalid PhoenixBase ID or Driver Application ID');
    }
}
