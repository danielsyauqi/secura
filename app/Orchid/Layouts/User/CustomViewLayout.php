<?php
// User.php

namespace App\Models;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Other methods and properties

    public function presenter()
    {
        return new UserPresenter($this);
    }
}

// UserPresenter.php

namespace App\Presenters;

class UserPresenter
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function image()
    {
        // Return the image URL or null if not available
        return $this->user->profile_photo_url ?? null;
    }

    public function title()
    {
        // Return the user's title or name
        return $this->user->name;
    }
}