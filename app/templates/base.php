<!doctype html>
<html>
<head>
  <title><?php echo $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="vendor/foundation-6.3.0/css/foundation.min.css">
</head>
<body>
  <nav class="top-bar">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li class="menu-text">Film Rental Service</li>
        <li><a href="<?php echo \Lib\url('/'); ?>">Home</a></li>

        <?php if(!$ctrl->isLoggedIn()): ?>
          <li><a href="<?php echo \Lib\url('/login/'); ?>">Log in</a></li>
        <?php endif; ?>

        <?php if($ctrl->isLoggedIn()): ?>
          <li><a href="<?php echo \Lib\url('/loans/'); ?>">Loans</a></li>
          <li><a href="<?php echo \Lib\url('/sales-figures/'); ?>">Sales Figures</a></li>
          <li><a href="<?php echo \Lib\url('/logout/'); ?>">Log out</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="top-bar-right">
     <ul class="menu">
       <?php if($ctrl->isLoggedIn()): ?>
         <li class="menu-text"><?php echo $ctrl->getCurrentUser()->getFullName(); ?></li>
       <?php endif; ?>
     </ul>
    </div>

  </nav>
  <div class="row">
    <div class="large-12 columns">
      <?php if($error): ?>
        <div class="callout primary">
          <p><?php echo $error; ?></p>
        </div>
      <?php endif; ?>
      <?php echo $content; ?>
    </div>
  </div>
</body>
</html>
