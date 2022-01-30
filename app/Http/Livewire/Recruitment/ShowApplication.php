<?php

namespace App\Http\Livewire\Recruitment;

use App\Mail\DriverApplication\ApplicationDenied;
use App\Models\Application;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Mail;
use Validator;

class ShowApplication extends Component
{
    use AuthorizesRequests;

    public Application $application;
    public Collection $previousApplications;
    public string $comment = '';

    protected array $rules = [
        'comment' => 'required',
    ];

    public function mount($uuid): void
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();

        $this->previousApplications = $this->findPreviousApplications();
    }

    public function render(): View
    {
        return view('livewire.recruitment.show')->extends('layouts.app');
    }

    public function claim(): void
    {
        $this->authorize('claim', $this->application);

        $this->application->claimed_by = Auth::id();
        $this->application->save();

        $this->forgetPendingApplicationCount();

        $this->sendDiscordWebhook('Application Claimed', '**' . Auth::user()->username . '** claimed **' . $this->application->username . '\'s** application.', 14429954);

        session()->now('alert', ['type' => 'info', 'message' => 'Application claimed']);
    }

    public function unclaim(): void
    {
        $this->authorize('update', $this->application);

        $this->application->claimed_by = null;
        $this->application->save();

        $this->forgetPendingApplicationCount();

        $this->sendDiscordWebhook('Application Unclaimed', '**' . Auth::user()->username . '** unclaimed **' . $this->application->username . '\'s** application.', 14429954);

        session()->now('alert', ['type' => 'info', 'message' => 'Application unclaimed']);
    }

    public function submitComment(): void
    {
        $commentData = $this->validate();

        $comment = new Comment([
            'body' => $commentData['comment'],
            'author' => Auth::id(),
        ]);

        $this->application->comments()->save($comment);

        // Empty the comment textarea
        $this->comment = '';

        $this->sendDiscordWebhook('New Application Comment', $commentData['comment'], 14429954);

        session()->now('alert', ['type' => 'success', 'message' => 'Comment submitted!']);
    }

    public function deleteComment($uuid): void
    {
        $comment = Comment::where('uuid', $uuid)->firstOrFail();

        $this->authorize('delete', $comment);

        $comment->delete();

        $this->sendDiscordWebhook('Application Comment Deleted', 'By **' . Auth::user()->username . '**', 14429954);

        session()->now('alert', ['type' => 'info', 'message' => 'Comment deleted!']);
    }

    public function clearTMPData(): void
    {
        \Cache::forget($this->application->truckersmp_id . "_truckersmp_data");
        \Cache::forget($this->application->truckersmp_id . "_truckersmp_ban_history");

        session()->now('alert', ['type' => 'success', 'message' => 'TruckersMP data successfully refreshed!']);
    }

    public function accept(): void
    {
        $this->authorize('update', $this->application);

        Validator::make($this->application->toArray(), [
            'username' => ['required', 'string', Rule::unique('users')->whereNull('deleted_at')],
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'truckersmp_id' => [Rule::unique('users')->whereNull('deleted_at')],
            'steam_data.steamID64' => ['required', Rule::unique('users', 'steam_id')->whereNull('deleted_at')],
        ])->validate();

        $this->emit('openModal', 'recruitment.show-accept-modal', ['uuid' => $this->application->uuid]);
    }

    public function deny(): void
    {
        $this->authorize('update', $this->application);

        $this->application->status = 'denied';
        $this->application->save();

        Mail::to([[
            'email' => $this->application->email,
            'name' => $this->application->username
        ]])->send(new ApplicationDenied($this->application));

        $this->sendDiscordWebhook('Application Denied', 'By **' . Auth::user()->username . '**', 15548997);

        session()->now('alert', ['type' => 'success', 'message' => 'Application successfully <b>denied</b>!']);
    }

    public function setStatus($status): void
    {
        $this->authorize('update', $this->application);

        $this->application->status = $status;
        $this->application->save();

        $this->sendDiscordWebhook('Application Status Changed: **' . ucwords(str_replace("_", " ", $status)) . '**', 'By **' . Auth::user()->username . '**', 5793266);

        session()->now('alert', ['type' => 'info', 'message' => 'Application status changed to <b>' . str_replace("_", " ", $status) . '</b>']);
    }

    public function hydrate(): void
    {
        $this->application = $this->application->fresh();
    }

    private function sendDiscordWebhook(string $title, string $description, int $color): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => $title,
                    'url' => route('recruitment.show', $this->application->uuid),
                    'description' => $description,
                    'color' => $color,
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
    }

    private function findPreviousApplications(): Collection
    {
        return Application::query()
            ->where('username', $this->application->email)
            ->orWhere(function ($query) {
                $query->where('email', $this->application->email)
                    ->when($this->application->discord_username, function ($q) {
                        return $q->orWhere('discord_username', $this->application->discord_username);
                    })
                    ->orWhere('truckersmp_id', $this->application->truckersmp_id)
                    ->orWhere('steam_data->steamID64', $this->application->steam_data['steamID64']);
            })
            ->whereKeyNot($this->application->id)
            ->latest()
            ->get();
    }

    private function forgetPendingApplicationCount(): void
    {
        Cache::forget('pending_application_count');
    }
}
