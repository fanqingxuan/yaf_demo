<?php

class TestController extends BaseController {

    /**
     *
     * @var [PostModel]
     */
    public $post;

    public function init() {
        $this->post = new PostModel;
    }

    public function addAction() {
        $post = [
            'user_id'   =>  11,
            'content'   =>  '这是内容',
            'title'     =>  '这是标题',
        ];
        $id = $this->post->create($post);
        $this->success('添加成功',['id'=>$id]);
    }

    public function delAction() {

        $success1 = $this->post->deleteByPk('1,2,3,4');
        $success2 = $this->post->deleteByPk([4,5,6]);
        $success3 = $this->post->delete(['id'=>[7,8,9]]);
        $this->success('删除成功',['success'=>$success1,'success2'=>$success2,'success3'=>$success3]);
    }

    public function updateAction() {
        $data = [
            'content'   =>  'hello world',
        ];
        //$affectRows = $this->post->updateByPk($data,'10,11,12');
        $affectRows = $this->post->update($data,['id'=>10]);

        $this->success('修改成功',['count'=>$affectRows]);
    }

    public function listAction() {
        $where = ['id'=>[10,11]];
        $data1 = $this->post->findByCondition($where,'title,content');
        $this->success('查询成功',['data1'=>$data1]);
    }

    public function createOrupdateAction() {
        $data = [
            'id'        =>  10,
            'content111'   =>  'add'
        ];
        $result = $this->post->query(" select * from post");
        $this->success('保存成功',['data1'=>$result]);
    }
}