<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class ShowTrackerInformationPage extends Component
{
    public array $latestYaml;
    public string $setupFileUrl;

    public function mount()
    {
        $yamlFile = Http::get(config('tracker.update_server_url') . '/latest.yml');

        if ($yamlFile->failed()) {
            session()->now('alert', [
                'type' => 'warning',
                'title' => 'Uh oh! This is awkward...',
                'message' => 'It looks like we couldn\'t fetch the most recent Phoenix Tracker information.<br>Try refreshing the page, and if the issue persists, please let us know!'
            ]);
        } else {
            $this->latestYaml = Yaml::parse($yamlFile);
            $this->setupFileUrl = $this->getSetupFileUrlFromYaml();
        }
    }

    public function render()
    {
        return view('livewire.tracker-information-page')->extends('layouts.app');
    }

    private function getSetupFileUrlFromYaml(): ?string
    {
        if (!$this->latestYaml['path']) {
            return null;
        }

        return config('tracker.update_server_url') . "/{$this->latestYaml['path']}";
    }
}
