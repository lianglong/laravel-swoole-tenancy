<?php
/**
 * Created by PhpStorm.
 * User: loong
 * Date: 11/17/21
 * Time: 3:16 PM
 */

namespace App\Models;

use Stancl\Tenancy\Contracts;
use Stancl\Tenancy\Database\Concerns;
use Illuminate\Support\Facades\Cache;
use Stancl\Tenancy\Tenancy;


class Tenant extends ModelBase implements Contracts\Tenant
{
    use Concerns\CentralConnection,
        Concerns\GeneratesIds,
        Concerns\HasDataColumn,
        Concerns\HasInternalKeys,
        Concerns\TenantRun,
        Concerns\InvalidatesResolverCache;

    protected $table = 'tenants';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function getTenantKeyName(): string
    {
        return 'key';
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->primaryKey);
    }

//    public function getOne($params,$refresh=null){
//        return Tenancy()->central(function ()use($params,$refresh){
//            if($refresh){
//                Cache::forget($this->modelCacheKey($params['tenant']));
//            }
//            return Cache::rememberForever($this->modelCacheKey($params['tenant']), function () use($params,&$refresh) {
//                if(!$refresh){
//                    if(!$refresh = $this->where('id',$params['tenant'])->first()){
//                        $refresh = [];
//                    }
//                }
//                return $refresh;
//            });
//        });
//
//    }

//    public static function getCustomColumns(): array
//    {
//        return [
//            'id',
//            'plan',
//            'locale',
//        ];
//    }
}