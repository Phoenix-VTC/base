<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Models\Company;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowEditPage extends Component
{
    public Company $company;

    public string $name = '';
    public ?string $category = '';
    public ?string $specialization = '';
    public ?string $dlc = '';
    public ?string $mod = '';
    public string $game_id = '1';

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'category' => ['sometimes'],
            'specialization' => ['sometimes'],
            'dlc' => ['sometimes'],
            'mod' => ['sometimes'],
            'game_id' => ['required', 'integer', Rule::in(['1', '2'])],
        ];
    }

    public function mount(): void
    {
        $this->fill([
            'name' => $this->company->name,
            'category' => $this->company->category,
            'specialization' => $this->company->specialization,
            'dlc' => $this->company->dlc,
            'mod' => $this->company->mod,
            'game_id' => $this->company->game_id,
        ]);
    }

    public function render(): View
    {
        return view('livewire.game-data.companies-edit')
            ->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        if (!$this->company->approved) {
            $this->forgetUnapprovedGameDataCount();

            session()->flash('alert', ['type' => 'success', 'message' => 'Company request <b>' . $this->company->name . '</b> successfully approved.']);

            // Only notify the user if the user still exists
            if ($this->company->requester()->exists()) {
                $this->company->requester->notify(new GameDataRequestApproved($this->company));
            }
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Company <b>' . $this->company->name . '</b> successfully updated.']);
        }

        $this->company->update([
            'name' => $this->name,
            'category' => $this->category,
            'specialization' => $this->specialization,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'game_id' => (int)$this->game_id,
            'approved' => true,
        ]);

        return redirect()->route('game-data.companies');
    }

    public function delete()
    {
        if (!$this->company->approved) {
            $this->forgetUnapprovedGameDataCount();

            // Only notify the user if the user still exists
            if ($this->company->requester()->exists()) {
                $this->company->requester->notify(new GameDataRequestDenied($this->company));
            }

            session()->flash('alert', ['type' => 'success', 'message' => 'Company request <b>' . $this->company->name . '</b> successfully denied.']);
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Company successfully deleted!']);
        }

        try {
            $this->company->delete();
        } catch (QueryException $e) {
            session()->now('alert', ['type' => 'danger', 'message' => 'You can\'t delete this company, it\'s used in a job somewhere!']);

            return;
        }

        return redirect()->route('game-data.companies');
    }

    private function forgetUnapprovedGameDataCount(): void
    {
        Cache::forget('unapproved_game_data_count');
    }
}
