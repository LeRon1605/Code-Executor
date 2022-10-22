<?php
    enum ExecutorStatus {
        case Pending;
        case Success;
        case CompilerError;
        case RuntimeError;
    }
?>