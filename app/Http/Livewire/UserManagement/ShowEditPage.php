<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use App\Rules\IncludesLetters;
use App\Rules\UsernameNotReserved;
use Auth;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ShowEditPage extends Component implements HasForms
{
    use AuthorizesRequests;
    use InteractsWithForms;

    public User $user;
    // Form fields
    public $username;
    public $slug;
    public $email;
    public $steam_id;
    public $truckersmp_id;
    public $date_of_birth;
    public $roles;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->authorize('update', $user);

        // Fill the form fields
        $this->form->fill([
            'username' => $this->user->username,
            'slug' => $this->user->slug,
            'email' => $this->user->email,
            'steam_id' => (string) $this->user->steam_id,
            'truckersmp_id' => $this->user->truckersmp_id,
            'date_of_birth' => $this->user->date_of_birth,
            'roles' => $this->user->roles->pluck('id')->toArray(),
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => ['bail', 'required', 'string', 'min:3', 'unique:users,username,' . $this->user->id, new UsernameNotReserved],
            'slug' => ['bail', 'required', 'string', 'min:3', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user->id), new IncludesLetters],
            'email' => ['bail', 'required', 'string', 'email', 'unique:users,email,' . $this->user->id],
            'steam_id' => 'required|numeric',
            'truckersmp_id' => 'required|numeric',
            'date_of_birth' => 'required|date|before_or_equal:' . Carbon::now()->subYears(16),
            'user_roles' => 'required|array'
        ];
    }

    public function render()
    {
        return view('livewire.user-management.edit-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('username')
                        ->required()
                        ->minLength(3)
                        ->unique(table: User::class, ignorable: $this->user)
                        ->rule(new UsernameNotReserved),

                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(table: User::class, ignorable: $this->user)
                        ->helperText(function () {
                            return 'Account activated via the initial welcome email: **' . ($this->user->welcome_valid_until ? 'no' : 'yes') . '**';
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->minLength(3)
                        ->helperText(fn (): string => url()->route('profile.fancy-redirect', $this->slug))
                        ->unique(table: User::class, ignorable: $this->user)
                        ->rule(new IncludesLetters),

                    Forms\Components\TextInput::make('steam_id')
                        ->label('Steam ID')
                        ->required()
                        ->numeric()
                        ->helperText(function () {
                            return "<u><a href='https://steamidfinder.com/lookup/{$this->user->steam_id}' target='_blank'>**Steam account information**</a></u>"
                                . '<br>Needs to be steamID64 (DEC)';
                        }),

                    Forms\Components\TextInput::make('truckersmp_id')
                        ->label('TruckersMP ID')
                        ->required()
                        ->numeric()
                        ->helperText(function () {
                            return "<u><a href='https://truckersmp.com/user/{$this->user->truckersmp_id}' target='_blank'>**View TruckersMP account**</a></u>";
                        }),

                    Forms\Components\DatePicker::make('date_of_birth')
                        ->required()
                        ->helperText(function () {
                            return 'The user must be at least 16 years old';
                        }),

                    Forms\Components\MultiSelect::make('roles')
                        ->options($this->getAvailableRoles())
                ]),
        ];
    }

    protected function getFormModel(): User
    {
        return $this->user;
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $this->user->update([
            'username' => $validatedData['username'],
            'slug' => Str::slug($validatedData['slug']) ?: $this->user->slug,
            'email' => $validatedData['email'],
            'steam_id' => $validatedData['steam_id'],
            'truckersmp_id' => $validatedData['truckersmp_id'],
            'date_of_birth' => $validatedData['date_of_birth'],
        ]);

        $this->user->syncRoles($this->roles);

        session()->flash('alert', ['type' => 'success', 'message' => 'Profile successfully updated!']);

        return redirect(route('users.profile', $this->user));
    }

    private function getAvailableRoles(): array
    {
        // Query all roles below or equal to the current user's role level
        $roles = Role::query()
            ->where('level', '<=', Auth::user()->roleLevel());

        // If the user isn't upper staff, remove all staff roles
        if (!Auth::user()->isUpperStaff()) {
            $roles->where('is_staff', false);
        }

        // If the user isn't a super admin, remove all upper staff roles
        if (!Auth::user()->isSuperAdmin()) {
            $roles->where('is_upper_staff', false);
        }

        return $roles
            ->orderByDesc('level') // Highest level first
            ->get() // Get the results
            ->pluck('name', 'id') // Convert them to key => value pairs
            ->toArray(); // Convert them to an array
    }
}
