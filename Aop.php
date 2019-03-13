<?php

/**
 * 提供简单的AOP功能
 * Provides simple AOP functionality
 * @author gf2007@vip.qq.com
 */
class SimpleAOP{
    protected $signs = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    protected $methodList = [];
    public function __call($method, $args)
    {
        $splitMethods = explode("_", $method);
        switch (count($splitMethods))
        {
            case 4: {
                $fontSign = $splitMethods[1];
                $mainMethod = $splitMethods[2];
                $backSign = $splitMethods[3];
                break;
            }

            case 3:
                {
                    if (is_numeric($splitMethods[1])) {

                        $fontSign = $splitMethods[1];
                        $mainMethod = $splitMethods[2];
                    }
                    else {
                        $mainMethod = $splitMethods[1];
                        $backSign = $splitMethods[2];
                    }
                    break;
                }
        }

        // Execution of pre-function
        foreach ($this->signs as $s) {
            if (strpos($s, $fontSign) !== false) {
                call_user_func_array(array($this->methodList[$s][0], $this->methodList[$s][1]),
                    $this->methodList[$s][2]);
            }
        }

        // Execution of pre-function
        call_user_func_array(array($this,$mainMethod), $args);

        // Execution post function
        foreach ($this->signs as $s) {
            if (strpos($s, $backSign) !== false) {
                call_user_func_array(array($this->methodList[$s][0], $this->methodList[$s][1]),
                    $this->methodList[$s][2]);
            }
        }

    }

    // Set function list
    public function setMethodList($methodList = []) {
        $this->methodList = $methodList;
    }
}

// ---------------------------------------------DEMO EXPLAIN------------------------------------------------------------
/**
 * 在原本执行的函数的前面和后面加上一些标记符号，使得函数在执行前执行前置函数，函数执行后执行后置函数;实现简单的AOP
 * Add some markup symbols before and after the function that is executed,
 * so that the function executes the pre-function before execution,
 * and executes the post-function after the function is executed; realizes simple AOP
 */

class Controller extends SimpleAOP{

    public function add() {
        echo "to do add function".PHP_EOL;
    }
}

/**
 * 提供外围函数，提供给Controller类使用
 * Provide peripheral functions for use by the Controller class
 */
class Demo{
    function font() {
        echo "font function running...".PHP_EOL;
    }

    function back() {
        echo "back function running...".PHP_EOL;
    }
}
$controller = new Controller();
/**
 * 将外围函数的方法与数组的索引对应
 * Correspond to the method of the peripheral function and the index of the array
 */
$controller->setMethodList([
    ["Demo","font",[1, 2]],
    ["Demo","back",[1, 2]]
]);
/**
 * 在执行add函数前，执行0索引对应的方法Demo::font
 * Before executing the add function,execute the method corresponding to the index 0 Demo::font
 */
$controller->_0_add();
/**
 * 在执行add函数后，执行1索引对应的方法Demo::back
 * After executing the add function,execute the method corresponding to the index 1 Demo::back
 */
$controller->_add_1();
/**
 * 在执行add函数前，先执行0索引对应的方法Demo::font
 * 在执行add函数后，先执行1索引对应的方法Demo::back
 * Before executing the add function, execute the method corresponding to the index 0 Demo::font
 * After executing the add function, execute the method corresponding to the index 1 Demo::back
 */
$controller->_0_add_1();
