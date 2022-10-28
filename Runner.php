<?php
    class Runner {
        private $compiler;
        public function __construct($compiler)
        {
            $this -> compiler = $compiler;
        }
        public function execute($code, $input) {
            $time = '';
            $memory = 0;
            $status = ExecutorStatus::Pending;

            $inputFilePath = "input.txt";

            if (!empty(trim($input))) {
                $inputFile = fopen($inputFilePath, 'w');
                fwrite($inputFile, $input);
                fclose($inputFile);
            }

            // compile code
            $error = $this -> compiler -> compile($code);
            
            if (strpos($error, 'error')) {
                $output = $error;
                $status = ExecutorStatus::CompilerError;
            }else{
                $output = $this -> compiler -> exec($code, $input);
                if ($output != false && $output != null) {
                    $time = $this -> getTime($output);
                    $output = $this -> getOutput($output);
                }
                $status = $output ? ExecutorStatus::Success : ExecutorStatus::RuntimeError;
            }

            if (!empty(trim($input))) {
               unlink($inputFilePath);
            }
            
            return new ExecutorResult($code, $input, $output, $time, $memory, $status);
        }

        public function getTime($str) {
            $arr = explode("\n", $str);
            $str = $arr[count($arr) - 2];
            $time = explode(":", $str);
            return ($time[0] * 60 * 1000 + $time[1]) * 1000;
        }

        public function getOutput($str) {
            return substr($str, 0, strlen($str) - 9);
        }
    }
?>