<?php
    class CompilerFactory {
        private static $cppCompiler;
        private static $javaCompiler;
        public static function getInstance($lang) {
            switch ($lang) {
                case "cpp":
                    if (self::$cppCompiler == null) {
                        self::$cppCompiler = new CppCompiler();
                    }
                    return self::$cppCompiler;
                case "java":
                    if (self::$javaCompiler == null) {
                        self::$javaCompiler = new JavaCompiler();
                    }
                    return self::$javaCompiler;
            }
        }
    }
?>