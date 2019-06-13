<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * option_type: main, side, both
     */
    const OT_MAIN = 'main';
    const OT_SIDE = 'side';
    const OT_BOTH = 'both';
}
