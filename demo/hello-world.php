<?php
use Befunge\Lang;

require ('../vendor/autoload.php');

$program = <<< 'EOD'
>              v
v  ,,,,,"Hello"<
>48*,          v
v,,,,,,"World!"<
>25*,@
EOD;

$lang = new Lang();
$lang->fromString($program);
$lang->run();

