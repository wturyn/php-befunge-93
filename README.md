php-befunge-93
==============

Befunge-93 interpreter written in PHP

Example (from /demo/hello-word.php)
------

```php
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
```
