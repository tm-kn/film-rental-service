<html>
<head>
  <title><?php echo $title; ?></title>
</head>
<body>
  <ul>
    <li><a href="<?php echo \Lib\url('/'); ?>">Home</a></li>
    <li><a href="<?php echo \Lib\url('/login/'); ?>">Log in</a></li>
  </ul>
  <?php echo $content; ?>
</body>
</html>
