<?php

$properties = ['user_id', 'birthday', 'address', 'phone', 'description'];

$properties = array_map(function ($property) {
    return preg_replace_callback('/(_[a-z])/', function ($matches) {
        return ucfirst(ltrim($matches[1], '_'));
    }, $property);
}, $properties);

$result = '/**' . PHP_EOL;
$result .= ' * @method int getId()' . PHP_EOL;

foreach ($properties as $property) {
    $result .= ' * @method string get' . ucfirst($property) . '()' . PHP_EOL;
    $result .= ' * @method $this set' . ucfirst($property) . '(string $value)' . PHP_EOL;
}
$result .= ' */';

echo $result;
