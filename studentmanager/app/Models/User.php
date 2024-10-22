<?php

namespace App\Models;

use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
     * @return HasMany
     */
    public function mentorOf()
    {
        return $this->hasMany(Classroom::class, 'mentor_id');
    }
    /**
     *  Retrieve all mentors attached to this user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentors(): HasMany
    {
        $instance = new ClassroomUser();
        
        return $this->newHasMany($instance->newQuery()->selectRaw("classroom_user.*, users.*")
            ->from('classroom_user')
            ->join('classrooms', 'classroom_user.classroom_id', '=', 'classrooms.id')
            ->join('users', 'users.id', '=', 'classrooms.mentor_id'), $this, 'user_id', $this->getKeyName());
    }

    /**
     * Return all messages from the user's inbox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Return total count of unread messages
     * @return int
     */
    public function unread_messages(): int
    {
        return $this->messages->where('read', 0)->count();
    }

    /**
     * Retrieve all classrooms this user is attached to
     *
     * @return BelongsToMany
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }

    /**
     * Look for any relation to user. In case of student look in classrooms
     * and parents for a relation. In case of parent look for children and
     * their classrooms for relation.
     *
     * @param int $studentId
     * @return bool
     */
    public function isRelatedToStudent(int $studentId): bool
    {
        return ($this->hasAnyRole('ROLE_STUDENT') && $this->studentRelated($studentId)) ||
            ($this->hasAnyRole('ROLE_PARENT') && $this->parentRelated($studentId));
    }

    private function parentRelated(int $id): bool
    {
        if ($this->children->find($id)) {
            return true;
        } else {
            foreach ($this->children as $child) {
                foreach ($child->classrooms as $classroom) {
                    if ($classroom->students->find($id)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
    private function studentRelated(int $id)
    {
        foreach ($this->classrooms as $classroom) {
            if ($classroom->students->find($id)) {
                return true;
            }
        }

        if ($this->parents->find($id)) {
            return true;
        }

        return false;
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

    public function hasAnyRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('name', $roles)->exists();
        }

        return $this->roles()->where('name', $roles)->exists();
    }

}
