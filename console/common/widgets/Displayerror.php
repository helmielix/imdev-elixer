<?php
namespace common\widgets;

use Yii;

class Displayerror
{

    /*
     *  array $modelerror
     *  array Value of $modelerror
     *  ['key' => [0 => 'pesan error']]
     *  ['key' => ['pesan error']]
    */
    public static function pesan($modelerror)
    {
		// return var_dump(is_array($modelerror));
        $error = array();
        foreach ($modelerror as $key) {
            $error[] = $key[0];
        }
        return implode($error, ', ');
    }
}
