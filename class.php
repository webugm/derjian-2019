<?php
class MyClass
{
    const CONSTANT = 'constant value';
    static $var0 = 100;
    
    public $var1 = 123;
    protected $var2 = 456;
    private $var3 = 789;
    
    function __construct($str){
        $this->hello_str = $str;
    }
    function __destruct() {
        print "Destroying\n";
    }
    public static function showStatic(){
        echo self::$var0 . "\n";
    }
    function showConstant() {
        echo  self::CONSTANT . "\n";
    }
}
$test = new MyClass("hello"); //建立新物件
$test::showStatic(); //印出$var0的值
$test->showStatic(); //跟上面那一行程式碼一樣行為
$test->showConstant(); //印出CONSTANT的值
echo "{$test->hello_str}\n"; //印出$hello_str
echo "{$test->var1}\n"; //印出$var1
echo "{$test::$var0}\n"; //印出$var0