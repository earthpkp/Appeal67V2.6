<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appeal_emp_comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_details',
        'emp_name',
        'comm_status_id',
        'dep_app_id',
    ];


    public function department(){
        return $this->hasOne(department::class,'dep_id','dep_app_id');
    }

}
