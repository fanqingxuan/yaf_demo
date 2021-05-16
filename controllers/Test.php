<?php

class TestController extends Controller {

    public function indexAction() {
        $this->success("成功",[11,22,33]);
    }  
    
    public function addAction() {
        $this->success("成功","addAction");
    }
}