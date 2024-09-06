<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Room;

class User extends Authenticatable
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

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }

    public function canAccessRoom($roomId){
        return $this->type == 'admin' || $this->isInRoom($roomId);
    }

    public function canManageRoom($roomId){
        return $this->type == 'admin' || $this->isAdminInRoom($roomId);
    }

    public function isInRoom($roomId){
        return $this->rooms()->where('room_id', $roomId)->exists();
    }

    public function isAdminInRoom($roomId){
        return $this->rooms()->where('room_id', $roomId)->where('type', 'admin')->exists();
    }
}
