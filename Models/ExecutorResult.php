<?php
    class ExecutorResult {
        private $code;
        private $input;
        private $output;
        private $time;
        private $memory;
        private $status;

        function __construct($code, $input, $output, $time, $memory, $status)
        {
            $this -> code = $code;
            $this -> input = $input;
            $this -> output = $output;
            $this -> time = $time;
            $this -> memory = $memory;
            $this -> status = $status;
        }

        function setCode($code) {
            $this -> code = $code;
        }
        function setInput($input) {
            $this -> input = $input;
        }
        function setOutput($output) {
            $this -> output = $output;
        }
        function setTime($time) {
            $this -> time = $time;
        }
        function setMemory($memory){
            $this -> memory = $memory;
        }
        function setStatus($status) {
            $this -> status = $status;
        }

        function getCode() {
            return $this -> code;
        }
        function getInput() {
            return $this -> input;
        }
        function getOutput() {
            return $this -> output;
        }
        function getTime() {
            return $this -> time;
        }
        function getMemory() {
            return $this -> memory;
        }
        function getStatus() {
            return $this -> status;
        }

        function getStrStatus() {
            switch ($this -> status) {
                case ExecutorStatus::Success:
                    return 'Success';
                case ExecutorStatus::CompilerError:
                    return 'Compiler Error';
                case ExecutorStatus::RuntimeError:
                    return 'Runtime Error';
                case ExecutorStatus::Pending:
                    return 'Pending';
            }
        }
    }
?>