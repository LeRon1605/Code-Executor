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
            $outputFilePath = "output_".$id.".exe";
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
                $output = shell_exec($command);
                $status = $output ? ExecutorStatus::Success : ExecutorStatus::RuntimeError;
                $time = shell_exec("powershell -command \"(Measure-Command { \"$command\" | Out-Default }).ToString()\"");
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
