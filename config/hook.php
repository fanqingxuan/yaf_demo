<?php

return [

   'hooks'  =>  [//继承自Hook类的钩子，在controller之前，之后触发
        GlobalSampleHook::class,//全局钩子
        ControllerSampleHook::class   =>  [HomeController::class,TestController::class],//控制器钩子
        ActionSampleHook::class       =>    [//action钩子

            TestController::class,//所有action有效
            //对only内action加钩子
            //HomeController::class   =>  ['except'=>'index']
            //HomeController::class   =>  ['except'=>'index,ddd']
            //HomeController::class   =>  ['except'=>['index','ddd']]

            //对except内action不加钩子，其它都加钩子
            //HomeController::class   =>  ['only'=>'index']
            HomeController::class   =>  ['only'=>'index,ddd']
            //HomeController::class   =>  ['only'=>['index','ddd']]

            //仅对指定action加钩子
            //HomeController::class   =>  ['index']
            //HomeController::class   =>  'index,ddd'
        ]

    ],

   'plugins'    =>  [//继承自Yaf_Plugin_Abstract类，支持Yaf框架提供的6个钩子
        MySampleHook::class
   ]
];
