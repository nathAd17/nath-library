<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'role',
        'total_points'
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
            'total_points' => 'integer',
        ];
    }

    // Role constants
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function bookReviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withPivot('earned_at');
    }

    public function gamificationLogs()
    {
        return $this->hasMany(GamificationLog::class);
    }

    // Scopes
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPustakawan()
    {
        return $this->role === 'pustakawan';
    }

    public function isAnggota()
    {
        return $this->role === 'anggota';
    }

    public function canManageBooks()
    {
        return in_array($this->role, ['admin', 'pustakawan']);
    }

    public function addPoints($points, $activity, $description = null)
    {
        $this->increment('total_points', $points);

        GamificationLog::create([
            'user_id' => $this->id,
            'activity_type' => $activity,
            'points_earned' => $points,
            'description' => $description,
        ]);
    }

}
