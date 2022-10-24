<?php
    class CppCompiler implements ICompiler {
        public function execute($code, $input)
        {
            $id = uniqid();
            $time = '';
            $memory = 0;
            $status = ExecutorStatus::Pending;

            $command = '';
            $inputFilePath = "input_".$id.".txt";
            $outputFilePath = "./output_".$id.".exe";
            $codeFilePath = "code_".$id.".cpp";
            $errorFilePath = "error_".$id.".txt";

            $codeFile = fopen($codeFilePath, 'w');
            fwrite($codeFile, $code);
            fclose($codeFile);

            if (!empty(trim($input))) {
                $inputFile = fopen($inputFilePath, 'w');
                fwrite($inputFile, $input);
                fclose($inputFile);
            }

            // compile code
            shell_exec("g++ -o $outputFilePath $codeFilePath 2> $errorFilePath");
            $error = file_get_contents($errorFilePath);
            
            if (strpos($error, 'error')) {
                $output = $error;
                $status = ExecutorStatus::CompilerError;
            }else{
                if (empty(trim($input))) {
                    $command = $outputFilePath;
                } else {
                    $command = "$outputFilePath < $inputFilePath";
                }
                
                $start = microtime(true);
                $output = shell_exec("wsl timeout 5s $command");
                $time = round((microtime(true) - $start) * 1000);
                $status = $output ? ExecutorStatus::Success : ExecutorStatus::RuntimeError;
                unlink($outputFilePath);
            }

            if (!empty(trim($input))) {
                unlink($inputFilePath);
            }
            unlink($errorFilePath);
            unlink($codeFilePath);
            
            return new ExecutorResult($code, $input, $output, $time, $memory, $status);
        }
    }
