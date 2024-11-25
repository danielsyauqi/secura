<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Picture;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;    
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\ProfilePasswordLayout;

class UserProfileScreen extends Screen
{
    /**
     * Display header name.
     *
     * @return string
     */
    public function name(): ?string
    {
        return 'Profile';
    }

    /**
     * Display header description.
     *
     * @return string
     */
    public function description(): ?string
    {
        return 'Update your profile information';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->type(Color::BASIC())
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            
            Layout::block(new UserEditLayout(true))
                ->title(__('Profile Information'))
                ->description(__("Update your account's profile information and email address."))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC())
                        ->icon('bs.check-circle')
                        ->method('save')
                ),

            Layout::block(ProfilePasswordLayout::class)
                ->title(__('Update Password'))
                ->description(__('Ensure your account is using a long, random password to stay secure.'))
                ->commands(
                    Button::make(__('Update password'))
                        ->type(Color::BASIC())
                        ->icon('bs.check-circle')
                        ->method('changePassword')
                ),
            
                
                
        ];
    }

    /**
     * Save the user profile information.
     *
     * @param Request $request
     */
    public function save(Request $request): void
    {
        $request->validate([
            'user.name'  => 'required|string',
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($request->user()),
            ],
            'user.profile_photo' => 'nullable|mimes:png,jpg,jpeg,gif|max:10240',

        ]);

        $user = $request->user();

        if ($request->hasFile('user.profile_photo')) {
            $file = $request->file('user.profile_photo');

            // Remove old profile photo if exists
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }

            // Store new profile photo and save only the relative path
            $path = $file->store('profile_photos');
            $user->profile_photo = $path;
        } else {
            // If no new profile photo is uploaded, keep the existing one
            $user->profile_photo = $user->getOriginal('profile_photo');
        }

        $user->fill($request->get('user'))->save();

        Toast::info(__('Profile updated.'));
    }

    /**
     * Change the user password.
     *
     * @param Request $request
     */
    public function changePassword(Request $request): void
    {
        $guard = config('platform.guard', 'web');
        $request->validate([
            'old_password' => 'required|current_password:'.$guard,
            'password'     => 'required|confirmed|different:old_password',
        ]);

        tap($request->user(), function ($user) use ($request) {
            $user->password = Hash::make($request->get('password'));
        })->save();

        Toast::info(__('Password changed.'));
    }

    
}