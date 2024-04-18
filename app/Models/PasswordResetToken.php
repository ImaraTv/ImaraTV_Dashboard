<?php

/**
 * Description of PasswordResetToken
 *
 * @author Ansel Melly <ansel@anselmelly.com> @anselmelly
 * @date Apr 18, 2024
 * @link https://anselmelly.com
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{

    public $timestamps = false;

    protected $table = "password_reset_tokens";

    protected $guarded = [];
}
