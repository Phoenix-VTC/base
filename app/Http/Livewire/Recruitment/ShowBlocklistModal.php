<?php

namespace App\Http\Livewire\Recruitment;

use App\Events\NewBlocklistEntry;
use App\Mail\DriverApplication\ApplicationDenied;
use App\Models\Application;
use App\Models\Blocklist;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Mail;

class ShowBlocklistModal extends ModalComponent
{
    use AuthorizesRequests;

    public Application $application;

    public string $reason = '';

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string'],
        ];
    }

    /**
     * @throws AuthorizationException
     */
    public function mount($uuid): void
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();

        $this->authorize('blocklist', $this->application);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.recruitment.components.blocklist-modal');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $this->application->status = 'denied';
        $this->application->save();

        Mail::to([[
            'email' => $this->application->email,
            'name' => $this->application->username
        ]])->send(new ApplicationDenied($this->application));

        $blocklist = Blocklist::query()->create([
            'usernames' => [(string)$this->application->username],
            'emails' => [(string)$this->application->email],
            'truckersmp_ids' => [(string)$this->application->truckersmp_id],
            'steam_ids' => [(string)$this->application->steam_data['steamID64']],

            'reason' => $validatedData['reason']
        ]);

        event(new NewBlocklistEntry($blocklist));

        session()->flash('alert', ['type' => 'success', 'message' => 'Blocklist entry added successfully!']);

        return redirect()->route('user-management.blocklist.show', $blocklist->id);
    }
}
