<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Job;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowShowPage extends Component
{
    public Job $job;
    public array $gmaps_data;

    public function mount(Job $job): void
    {
        $this->job = $job->load('user', 'pickupCity', 'destinationCity');

        $this->addGMapsData();
    }

    public function render(): View
    {

        return view('livewire.jobs.show-page')->extends('layouts.app');
    }

    public function delete()
    {
        if (!Auth::user()->can('manage users')) {
            abort(403, 'You don\'t have permission to delete jobs.');
        }

        $job = $this->job;
        $this->job->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully deleted!']);
        return redirect()->route('users.jobs-overview', $job->user_id);
    }

    private function addGMapsData()
    {
        try {
            // Try to locate pickup city
            $pickup_city = json_decode(
                \GoogleMaps::load('placeautocomplete')
                    ->setParam(['input' => $this->job->pickupCity->real_name])
                    ->get()
            );

            // Try to locate destination city
            $destination_city = json_decode(
                \GoogleMaps::load('placeautocomplete')
                    ->setParam(['input' => $this->job->destinationCity->real_name])
                    ->get()
            );

            // Load a new Google Maps instance with Mapper (with easter egg coords), and then add the route
            Mapper::map('35.65906740421891', '139.70062579556708', ['eventBeforeLoad' => 'addRoute(map_0);']);

            $this->gmaps_data = [
                'origin' => $pickup_city->predictions[0]->description,
                'destination' => $destination_city->predictions[0]->description
            ];
        } catch (\Exception $e) {
            session()->now('alert', ['type' => 'info', 'title' => 'We couldn\'t load the route map.', 'message' => 'We had some issues trying to parse the location.<br>Perhaps the pickup and/or destintion city doesn\'t exist in real-life?']);
        }
    }
}
