<?php

/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/4
 * Time: 20:21
 */
namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
}