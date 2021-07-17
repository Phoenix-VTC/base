<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Job;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class ShowShowPage extends Component
{
    public Job $job;

    public function mount(Job $job): void
    {
        $this->job = $job->load('user', 'pickupCity', 'destinationCity');

        // trying to locate origin
        $origin = json_decode(
            \GoogleMaps::load('placeautocomplete')
                ->setParam(['input' =>'Sporthallen Zuid'])
                ->get()
        );

        // trying to locate destination
        $destination = json_decode(
            \GoogleMaps::load('placeautocomplete')
                ->setParam(['input' =>'Vijfmeihal'])
                ->get()
        );

        // trying to gecode origin
        $place = json_decode(
            \GoogleMaps::load('geocoding')
                ->setParamByKey('place_id', $origin->predictions[0]->place_id)
                ->get()
        );

        Mapper::map($place->results[0]->geometry->location->lat, $place->results[0]->geometry->location->lng, ['eventBeforeLoad' => 'addRoute(map_0);']);

        // trying to calculate route
        $route = \GoogleMaps::load('directions')
            ->setParam([
                'origin' => $origin->predictions[0]->description,
                'destination' => $destination->predictions[0]->description,
                'travelmode' => 'DRIVING'
            ])
            ->get();
    }

    public function render(): View
    {

        return view('livewire.jobs.show-page')->extends('layouts.app');
    }

    public function delete(): Redirector
    {
        if (!Auth::user()->can('manage users')) {
            abort(403, 'You don\'t have permission to delete jobs.');
        }

        $this->job->delete();

        return redirect()->route('jobs.personal-overview');
    }
}
