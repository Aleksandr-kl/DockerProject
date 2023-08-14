<?php

namespace App\Models;

use App\Core\Database\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $date
 */
class News extends ActiveRecord
{

    public function __construct()
    {
        $this->table = 'news';
        parent:: __construct();
    }

}