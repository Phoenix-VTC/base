<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowApplication extends Component
{
    public object $application;
    public object $ban_history;

    public function mount($uuid)
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();

        $client = new Client();
        $response = $client->request('GET', 'https://api.truckersmp.com/v2/bans/' . $this->application->truckersmp_data['id'])->getBody();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $this->ban_history = collect($response['response'])->reverse();
    }

    public function claim()
    {
        $this->application->claimed_by = Auth::id();
        $this->application->save();
    }

    public function unclaim()
    {
        $this->application->claimed_by = null;
        $this->application->save();
    }

    public function render()
    {
        return view('livewire.recruitment.show')->extends('layouts.app');
    }
}
