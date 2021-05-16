<?php

class TestController extends Controller {

    public function indexAction() {
        $this->redirect("/test/add");
        $this->success("成功",[11,22,33]);
    }  
    
    public function addAction() {
        $this->success("成功","addAction");
    }
}