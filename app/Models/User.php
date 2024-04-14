<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function migration(Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->boolean('administrator')->default(false);
        $table->rememberToken();
        $table->timestamps();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $panelId = $panel->getId();

        switch ($panelId) {
            case 'admin':
                if ($this->administrator) return true;
                return false;
            case 'app':
                if ($this->administrator) return true;
                $tenant = Session::get('tenant');

                if ($tenant instanceof  Tenant) {
                    if ($this->id === $tenant->owner_id) {
                        return true;
                    }

                }

                return false;
            default:
                return false;
        }
    }
}
