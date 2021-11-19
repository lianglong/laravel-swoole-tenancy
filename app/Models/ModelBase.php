<?php
/**
 * Created by PhpStorm.
 * User: loong
 * Date: 11/17/21
 * Time: 10:52 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelBase extends Model
{
    use HasFactory;

    public function modelCacheKey($key){
        return 'model:'.get_called_class().':'.$key;
    }

    public function simplePaginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $ret = parent::simplePaginate($perPage, $columns, $pageName, $page)->toArray()??[];
        unset($ret['first_page_url'],$ret['next_page_url'],$ret['path'],$ret['prev_page_url']);
        return $ret;
    }

    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $ret = parent::paginate($perPage, $columns, $pageName, $page)->toArray()??[];
        unset($ret['first_page_url'],$ret['next_page_url'],$ret['path'],$ret['prev_page_url'],$ret['last_page_url'],$ret['links']);
        return $ret;
    }
}