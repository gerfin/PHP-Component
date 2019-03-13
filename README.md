# PHP-Component
* 提供简单的AOP功能  * Provides simple AOP functionality

// 可以定义或者引用其他的类，如日志类，权限类

// Can define or reference other classes, such as log classes, permission classes
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
