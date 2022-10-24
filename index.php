<?php
    include('./Compiler/ICompiler.php');
    include('./Models/ExecutorResult.php');
    include('./Models/ExecutorStatus.php');
    include('./Compiler/CppCompiler.php');
    
    if (isset($_POST['code'])) {
        $compiler = new CppCompiler();
        $result =  $compiler -> execute($_POST['code'], $_POST['input']);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex">
        <form 
            class="col-6" 
            method="POST"
            action=<?php echo $_SERVER['PHP_SELF']?>
        >
            <div class="m-3 col-12">
                <label class="form-label">Code</label>
                <textarea class="form-control" name="code" rows="20"><?php echo isset($result) ? $result-> getCode() : ''?></textarea>
            </div>
            <div class="m-3 col-12">
                <label class="form-label">Input</label>
                <textarea class="form-control" name="input" rows="3"><?php echo isset($result) ? $result-> getInput() : ''?></textarea>
            </div>
            <button class="btn btn-primary d-flex ms-auto">Submit</button>
        </form>
        <div class="m-3 ms-5 col-5">
            <label class="form-label">Output</label>
            <textarea class="form-control" name="code" rows="7"><?php echo isset($result) ? $result-> getOutput() : ''?></textarea>
            <div class="mt-3">
                <span>Status: <?php echo isset($result) ? $result-> getStrStatus() : ''?></span><br>
                <span>Time: <?php echo isset($result) ? $result-> getTime().' Ms' : ''?></span>
                <span>Memory: <?php echo isset($result) ? $result-> getMemory().' Kb' : ''?></span>
            </div>
        </div>
    </div>
</body>

</html>