<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class User extends Authenticatable implements MustVerifyEmail
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

    public function relatedToStudent(int $studentId)
    {
        if ($this->hasRole('ROLE_PARENT')) {
            // Check if student is a child
        }
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
            if (!in_array($class->mentor(), $mentors)) {
                array_push($mentors, $class->mentor());
            }
        }
        return $mentors;
    }

    /**
     * Return all messages from the user's inbox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class);
    }

    /**
     * Return total count of unread messages
     * @return int
     */
    public function unread_messages(): int
    {
        return count($this->messages()->get()->where('read', 0));
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
