<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class strGroup extends Model
{
    protected $table = "im_store_group";
    protected $primarKey = "id";
    protected $fillable = [
            'store_group_code',
            'store_group_desc',
            'status',
        ];
}
