<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Appeal extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;
    protected $primaryKey = 'app_id';
        
   
  /*  protected $fillable = [
        'name',
        'email',
        'password',
    ];
 */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_doc',
        'app_gender',
        'app_fname',
        'app_lname',
        'app_cardID',
        'app_email',
        'app_tel',
        'app_typedetail',
        'app_headdetail',
        'app_detail',
        'status_id',
        'app_active',
    
    ];
    protected $casts = [
        'app_cardID' => 'encrypted',
    ];


   
    public function status(){
        return $this->hasOne(status::class,'status_id','status_id');
    }

/*     public function FrontUser(){
        return $this->hasMany(FrontUser::class,'id','user_id');
    } */
    public function comments()
    {
        return $this->hasMany(appeal_emp_comment::class,'comm_app_id','app_id');
    }

    public function department(){
        return $this->hasOne(department::class,'dep_id','dep_app_id');
    }
    
    public function dep()
    {
        return $this->hasOne(department::class,'dep_id','dep_id');
    }
}
