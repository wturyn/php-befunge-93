<?php
require ('../vendor/autoload.php');

use Befunge\Lang;

$program = <<< 'EOD'
>              v
v  ,,,,,"Hello"<
>48*,          v
v,,,,,,"World!"<
>25*,@
EOD;

$lang = new Lang();
$lang->fromString($program);
echo($lang->run());

