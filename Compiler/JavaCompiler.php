<?php
    class JavaCompiler implements ICompiler {
        public function compile($code)
        {
            $codeFile = fopen("Main.java", 'w');
            fwrite($codeFile, $code);
            fclose($codeFile);
            shell_exec("wsl javac Main.java 2> error.txt");
            unlink("Main.java");
            $error = file_get_contents("error.txt");
            unlink("error.txt");
            return $error;
        }
        public function exec($code, $input)
        {
            if (empty(trim($input))) {
                $command = "java Main";
            } else {
                $command = "java Main < input.txt";
            }
            $output = shell_exec("wsl timeout 5s /usr/bin/time -f \"%E\" $command; 2>&1");
            unlink("Main.class");
            return $output;
        }
    }
?>