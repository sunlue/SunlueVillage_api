<?php

namespace app\village_api\controller\portal\article\attach;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalArticleAttr;
use think\facade\Db;

class File extends eVillageApi {
    protected function initialize() {
        parent::_init();
        parent::_checkToken();
    }

    public function delete() {
        $path = parse_url(input('delete.path'));
        $filename = app()->getRootPath() . 'public' . $path['path'];
        if (!file_exists($filename) || empty($path['path'])) {
            $this->ajaxReturn(400, '文件不存在');
        }
        Db::startTrans();
        try {
            if (PortalArticleAttr::destroy(input('delete.uniqid'))){
                unlink($filename);
            }
            Db::commit();
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}