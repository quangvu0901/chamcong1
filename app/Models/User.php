<?php

namespace App\Models;
use App\Casts\BooleanCast;
use App\Casts\EmailCast;
use App\Casts\IntegerCast;
use App\Casts\StringCast;
use App\Traits\AccessModuleTraits;
use App\Traits\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

use App\Casts\JsonCast;
use App\Casts\LogoCast;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasPermissionsTrait;
    use AccessModuleTraits;

    protected $table = 'users';

    protected $fillable = ["name", "email","password", "email_verified_at", "current_team_id", "profile_photo_path", "is_admin", "company_id", "department_id", "level", "position_id"];

    public static $listFields = ["id", "name", "email", "email_verified_at", "remember_token", "current_team_id", "profile_photo_path", "created_at", "updated_at", "is_admin", "company_id", "department_id", "level", "position_id"];
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    public function company(){
        return $this->belongsTo(Company::class,"company_id","id");
    }
    public function department(){
        return $this->belongsTo(Department::class,"department_id","id");
    }
    public function position(){
        return $this->belongsTo(Position::class,"position_id","id");
    }
    public function team(){
        return $this->belongsTo(Team::class, "current_team_id" ,"id");
    }
    public function timekeep(){
        return $this->hasMany(TimeKeep::class, "user_id", "id");
    }

    protected $casts = [
        "name" => StringCast::class,
		"email" => EmailCast::class,
		"password" => StringCast::class,
		"remember_token" => StringCast::class,
		"is_admin" => BooleanCast::class,
		"level" => IntegerCast::class,
		"other_info" => JsonCast::class,
        "profile_photo_url" => LogoCast::class,

    ];

}
