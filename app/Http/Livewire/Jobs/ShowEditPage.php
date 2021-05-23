<?php

namespace App\Http\Livewire\Jobs;

use App\Enums\JobStatus;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowEditPage extends Component
{
    public Job $job;
    // Form fields
    public string $pickup_city = '';
    public string $destination_city = '';
    public string $pickup_company = '';
    public string $destination_company = '';
    public string $cargo = '';
    public string $finished_at = '';
    public string $distance = '';
    public string $load_damage = '';
    public string $estimated_income = '';
    public string $total_income = '';
    public string $comments = '';

    public function mount(): void
    {
        if ($this->job->user_id !== Auth::id() || (Auth::user()->cannot('manage users') && $this->job->user_id === Auth::id() && $this->job->created_at->addHour()->isPast())) {
            abort(403, 'You don\'t have permission to edit this job.');
        }

        $this->fill([
            'finished_at' => $this->job->finished_at,
            'distance' => $this->job->distance,
            'load_damage' => $this->job->load_damage,
            'estimated_income' => $this->job->estimated_income,
            'total_income' => $this->job->total_income,
            'comments' => $this->job->comments,
        ]);
    }

    public function rules(): array
    {
        return [
            'finished_at' => ['required', 'date', 'after_or_equal:' . date('Y-m-d', strtotime('-7 days')), 'before_or_equal:today'],
            'distance' => ['required', 'integer', 'min:1', 'max:5000'],
            'load_damage' => ['required', 'integer', 'min:0', 'max:100'],
            'estimated_income' => ['required', 'integer', 'min:1', 'max:400000'],
            'total_income' => ['required', 'integer', 'min:1', 'max:' . $this->estimated_income],
            'comments' => ['sometimes', 'string'],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.jobs.edit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $this->job->update([
            'finished_at' => $validatedData['finished_at'],
            'distance' => $validatedData['distance'],
            'load_damage' => $validatedData['load_damage'],
            'estimated_income' => $validatedData['estimated_income'],
            'total_income' => $validatedData['total_income'],
            'comments' => $validatedData['comments'],
            'status' => JobStatus::Complete,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully edited!']);

        return redirect()->route('jobs.show', $this->job);
    }
}
