<?php

use app\ClassD;

//定义根目录路径
define("ROOT",__DIR__.DIRECTORY_SEPARATOR);

/**
 * 功能：自动装载类
 * @author li914
*/
class AutoloadClass
{
    /**
     * 功能：自动装载静态方法
     * @param string $className 类名 例如：ClassA 或 app/ClassD
     * @return void
    */
    public static function autoload($className)
    {
        $classPath = ROOT;
        //获取 名称空间名称
        $namespace = mb_substr($className,0,mb_strpos($className,"\\"));
        //判断是否存在 名称空间
        if (!empty($namespace)){
            $classPath .= $namespace.DIRECTORY_SEPARATOR;
        }
        //判断是否 已存在类
        if (class_exists($className)){
            return;
        }
        //获取类名
        $class = mb_substr($className,mb_strlen($namespace));
        $classPath .= $class.".php";

        if (file_exists($classPath)){
            include_once $classPath;
        }else{
            //若未找到 则抛出异常
            throw new RuntimeException("$className file $classPath not found!");
        }
    }
}

/**
 * $autoload_function 自动加载方法
 * $throw 是否抛出注册失败异常
 * $prepend 是否放到队首
*/
spl_autoload_register('AutoloadClass::autoload',true,true);

$classA = new ClassA();
$classd = new ClassD();

