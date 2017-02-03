<?php namespace Lib;

function url($path, $args=[]) {
  $url = 'index.php?path=' . $path;

  foreach($args as $key => $val) {
    $url .= '&' . $key . '=' . $val;
  }

  return $url;
}
