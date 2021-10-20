<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Student extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $table = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sex', 'age', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function teachers() : BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_follow', 'student_id', 'teacher_id');
    }
}
