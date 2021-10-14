<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class TeacherModel extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $table = 'teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sex', 'age',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function students() : BelongsToMany {
        return $this->belongsToMany(StudentModel::class, TeacherInviteModel::class, 'teacher_id', 'student_id');
    }
}
