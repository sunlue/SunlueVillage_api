<?php

namespace app\village_api\controller\portal\article\page;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalArticleAttr;
use app\village_api\model\PortalArticleImage;
use app\village_api\model\PortalArticlePage;
use think\facade\Db;

class Data extends eVillageApi {

    private $model;

    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new PortalArticlePage();
    }

    /**
     * 创建文章页面数据
     * @param array $data
     */
    protected function create($data = array()) {
        Db::startTrans();
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            if (!empty($data['attach_list'])){
                $attachList=[];
                $file=new \finfo(FILEINFO_MIME_TYPE);
                foreach ($data['attach_list'] as $attach){
                    $fileLink=app()->getRootPath().'public'.$attach['link'];
                    $fileInfo=pathinfo($attach['link']);
                    $attachList[]=array(
                        'type'=>2,
                        'unique'=>$saveData['uniqid'],
                        'name'=>$attach['name'],
                        'link'=>$attach['link'],
                        'size'=>$attach['size'],
                        'mime'=>$file->file($fileLink),
                        'dirname'=>$fileInfo['dirname'],
                        'basename'=>$fileInfo['basename'],
                        'extension'=>$fileInfo['extension'],
                        'filename'=>$fileInfo['filename'],
                    );
                }
                $attachModel=new PortalArticleAttr();
                $attachModel->saveAll($attachList);
            }
            if (!empty($data['image_list'])){
                $imageList=[];
                $file=new \finfo(FILEINFO_MIME_TYPE);
                foreach ($data['image_list'] as $attach){
                    $fileLink=app()->getRootPath().'public'.$attach['link'];
                    $fileInfo=pathinfo($attach['link']);
                    $imageList[]=array(
                        'type'=>2,
                        'unique'=>$saveData['uniqid'],
                        'name'=>$attach['name'],
                        'link'=>$attach['link'],
                        'size'=>$attach['size'],
                        'mime'=>$file->file($fileLink),
                        'dirname'=>$fileInfo['dirname'],
                        'basename'=>$fileInfo['basename'],
                        'extension'=>$fileInfo['extension'],
                        'filename'=>$fileInfo['filename'],
                    );
                }
                $imageModel=new PortalArticleImage();
                $imageModel->saveAll($imageList);
            }
            Db::commit();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除文章页面数据
     * @param $uniqid
     */
    protected function delete($uniqid) {
        try {
            $this->model->destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改文章页面数据
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        try {
            unset($data['uniqid']);
            unset($data['create_time']);
            unset($data['update_time']);
            $field = array_column($this->model->getFields(), 'name');
            $data = array_filter($data, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $data['tag'] = is_array($data['tag']) ? implode(',', array_column($data['tag'], 'value')) : '';
            $this->model->where('uniqid', $uniqid)->save($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $this->model->getLastSql());
        }
    }

    /**
     * 修改文章页面数据字段
     * @param $uniqid
     * @param $field
     * @param $value
     */
    protected function updateAericleField($uniqid, $field, $value) {
        try {
            $this->model->where('uniqid', $uniqid)->data(array(
                $field => $value
            ))->update();
            $this->ajaxReturn(200, array(
                $field => $value
            ));
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }


    /**
     * 获取文章页面数据
     * @param $where
     */
    protected function read($where) {
        if (input('param.page')) {
            $data = PortalArticlePage::getList($where);
        } else {
            $data = PortalArticlePage::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}