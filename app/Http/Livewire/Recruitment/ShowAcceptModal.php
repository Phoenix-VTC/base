<?php

namespace App\Http\Livewire\Recruitment;

use App\Jobs\Recruitment\ProcessAcceptation;
use App\Models\Application;
use Carbon\Carbon;
use GuzzleHttp\Command\Exception\CommandClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ItemNotFoundException;
use LivewireUI\Modal\ModalComponent;
use RestCord\DiscordClient;
use RestCord\Model\Guild\GuildMember;

class ShowAcceptModal extends ModalComponent
{
    use AuthorizesRequests;

    public Application $application;

    public string $discord_id = '';

    public function rules(): array
    {
        return [
            'discord_id' => ['required', 'int', 'min:1'],
        ];
    }

    protected array $validationAttributes = [
        'discord_id' => 'Discord ID',
    ];

    /**
     * @throws AuthorizationException
     */
    public function mount($uuid): void
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();

        $this->authorize('update', $this->application);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.recruitment.components.accept-modal');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        // Create a new Discord client
        $client = new DiscordClient(['token' => config('services.discord.token')]);

        // Try to find the user in the guild
        try {
            $member = $client->guild->getGuildMember([
                'guild.id' => (int) config('services.discord.server-id'),
                'user.id' => (int) $validatedData['discord_id'],
            ]);
        } catch (CommandClientException $e) {
            return $this->addError('foo', 'This user is not in the Phoenix guild.');
        }

        // Try to find the Community Member role
        try {
            $communityRole = $this->getCommunityMemberRole($client);
        } catch (ItemNotFoundException) {
            return $this->addError('bar', 'Could not find the Community Member role in the configured guild. Please contact a Developer.');
        }

        // Try to find the Phoenix Member role
        try {
            $memberRole = $this->getPhoenixMemberRole($client);
        } catch (ItemNotFoundException) {
            return $this->addError('baz', 'Could not find the Phoenix Member role in the configured guild. Please contact a Developer.');
        }

        // Check if the user already has the Phoenix Member role, but only if the code isn't being executed in a test
        if (! App::runningUnitTests() && in_array($memberRole->id, $member->roles, true)) {
            return $this->addError('bam', 'This user already has the Phoenix Member role.');
        }

        // Dispatch the job to process the acceptation
        ProcessAcceptation::dispatch($this->application, $member->user);

        // Remove the user's Community Member role, if they have it
        if (in_array($communityRole->id, $member->roles, true)) {
            $client->guild->removeGuildMemberRole([
                'guild.id' => (int) config('services.discord.server-id'),
                'user.id' => (int) $validatedData['discord_id'],
                'role.id' => $communityRole->id,
            ]);
        }

        // Give the user the Phoenix Member role
        $client->guild->addGuildMemberRole([
            'guild.id' => (int) config('services.discord.server-id'),
            'user.id' => (int) $validatedData['discord_id'],
            'role.id' => (int) $memberRole->id,
        ]);

        // Send the welcome message in #member-chat
        $this->sendWelcomeMessage($client, $member);

        $this->sendDiscordWebhook('Application Accepted', 'By **'.Auth::user()->username.'**', 5763719);

        session()->flash('alert', ['type' => 'success', 'message' => 'Application successfully <b>accepted</b>!']);

        return redirect()->route('recruitment.show', $this->application->uuid);
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
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                    ],
                    'timestamp' => Carbon::now(),
                ],
            ],
        ]);
    }

    private function getCommunityMemberRole(DiscordClient $client)
    {
        // Get and collect the guild roles
        $roles = $client->guild->getGuildRoles(['guild.id' => (int) config('services.discord.server-id')]);
        $roles = collect($roles);

        return $roles->where('name', 'Community Member')->firstOrFail();
    }

    private function getPhoenixMemberRole(DiscordClient $client)
    {
        // Get and collect the guild roles
        $roles = $client->guild->getGuildRoles(['guild.id' => (int) config('services.discord.server-id')]);
        $roles = collect($roles);

        return $roles->where('name', 'Phoenix Member')->firstOrFail();
    }

    private function sendWelcomeMessage(DiscordClient $client, GuildMember $member): void
    {
        $client->channel->createMessage([
            'channel.id' => (int) config('services.discord.channels.member-chat'),
            'content' => "<@{$member->user->id}>",
            'embed' => [
                'title' => 'A new driver joined our company!',
                'description' => "
                    Please welcome <@{$member->user->id}> to Phoenix! We hope you enjoy your stay here as a driver. <:PhoenixLove:797449175171727360>\n
                    <:Play:808490005357658164> If you haven't yet, make sure to join our TruckersMP VTC page at https://truckersmp.com/vtc/phoenix.
                    <:Play:808490005357658164> You can log jobs manually or with an auto tracker on our PhoenixBase here: https://base.phoenixvtc.com.
                    <:Play:808490005357658164> Enjoy your time here! If you have any questions, please don't be afraid to ask them in <#785558597550866442>!
                ",
                'color' => 14429954,
                'thumbnail' => [
                    'url' => 'https://base.phoenixvtc.com/img/logo.png',
                ],
                'image' => [
                    'url' => 'https://media1.giphy.com/media/9qxqNBtyucNqyFccMJ/giphy.gif',
                ],
                'footer' => [
                    'text' => 'Member Updates',
                    'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                ],
                'timestamp' => Carbon::now(),
            ],
        ]);
    }
}
