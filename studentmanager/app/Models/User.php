<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

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
        'dob',
        'phone',
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

    /**
     * Retrieve any children attached to user
     *
     * @return BelongsToMany
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_user', 'parent_id', 'user_id');
    }
    /**
     * Retrieve any parents attached to user
     *
     * @return BelongsToMany
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_user', 'user_id', 'parent_id');
    }
    /**
     * Retrieve any classrooms where this user is the mentor
     *
     * @return BelongsToMany
     */
    public function mentorOf()
    {
        return $this->belongsToMany(Schoolclass::class, 'mentor_user', 'mentor_id', 'classroom_id');
    }
    /**
     * Retrieve all mentors attached to this user
     *
     * @return array
     */
    public function mentors(): array
    {
        $mentors = [];
        foreach ($this->classrooms()->get() as $class) {
            array_push($mentors, $class->mentor());
        }
        return $mentors;
    }
    /**
     * Retrieve all classrooms this user is attached to
     *
     * @return BelongsToMany
     */
    public function classrooms()
    {
        return $this->belongsToMany(Schoolclass::class)->withTimestamps();
    }
    /**
     * Retrieve the roles of the user
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps(); // PIVOT
    }

    public function hasRole(string $role): bool
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
    public function hasAnyRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
            return false;
        } else {
            return $this->hasRole($roles);
        }
    }

}
