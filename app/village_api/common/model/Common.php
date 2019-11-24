<?php
/**
 * User: xiebing
 * Date: 2019/6/4
 * Time: 16:00
 */

namespace app\village_api\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Common extends Model {
    use SoftDelete;
    protected $defaultSoftDelete = 0;
    protected $autoWriteTimestamp = 'int';
    protected $deleteTime = 'delete_time';
}