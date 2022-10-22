<?php
    class CppCompiler implements ICompiler {

        public function execute($code, $input)
        {
            $id = uniqid();
            $inputFilePath = "input_".$id.".txt";
            $outputFilePath = "output_".$id.".exe";
            $codeFilePath = "code_".$id.".cpp";
            $errorFilePath = "error_".$id.".txt";

            $codeFile = fopen($codeFilePath, 'w');
            fwrite($codeFile, $code);
            fclose($codeFile);

            $inputFile = fopen($inputFilePath, 'w');
            fwrite($inputFile, $input);
            fclose($inputFile);

            // compile code
            shell_exec("g++ -o $outputFilePath $codeFilePath 2> $errorFilePath");
            $error = file_get_contents($errorFilePath);
            
            if (strpos($error, 'error')) return $error;

            if (empty(trim($input))) {
                $output = shell_exec($outputFilePath);
            } else {
                $output = shell_exec($outputFilePath." < $inputFilePath");
            }

            unlink($inputFilePath);
            unlink($outputFilePath);
            unlink($errorFilePath);
            unlink($codeFilePath);
            
            return $output;
        }
    }
?>