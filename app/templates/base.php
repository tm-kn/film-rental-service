<html>
<head>
  <title><?php echo $title; ?></title>
</head>
<body>
  <div>
    <?php if($error): ?>
      <div>
        <p><?php echo $error; ?></p>
      </div>
    <?php endif; ?>
  </div>
  <ul>
    <li><a href="<?php echo \Lib\url('/'); ?>">Home</a></li>
    <li><a href="<?php echo \Lib\url('/login/'); ?>">Log in</a></li>
    <li><a href="<?php echo \Lib\url('/logout/'); ?>">Log out</a></li>
  </ul>
  <?php echo $content; ?>
</body>
</html>
