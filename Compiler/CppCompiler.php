<?php
    class CppCompiler implements ICompiler {
        public function compile($code)
        {
            $codeFile = fopen("main.cpp", 'w');
            fwrite($codeFile, $code);
            fclose($codeFile);
            shell_exec("g++ -o main.exe main.cpp 2> error.txt");
            unlink("main.cpp");
            $error = file_get_contents("error.txt");
            unlink("error.txt");
            return $error;
        }
        public function exec($code, $input)
        {
            if (empty(trim($input))) {
                $command = "./main.exe";
            } else {
                $command = "./main.exe input.txt";
            }
            $output = shell_exec("wsl ./Bash/entrypoint.sh $command; 2>&1");
            unlink("main.exe");
            return $output;
        }
    }
