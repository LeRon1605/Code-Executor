<?php
    interface ICompiler {
        public function compile($code);
        public function exec($code, $input);
    }
?>