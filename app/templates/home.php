<div>
  <p>Welcome to the home page</p>
  <?php if($ctrl->isLoggedIn()): ?>
    <p>You are logged in as <?php echo $ctrl->getCurrentUser()->getFullName(); ?></p>
  <?php endif; ?>
  <?php foreach($employees as $employee): ?>
    <li>
      User: <?php echo $employee->getNiNumber(); ?> - <?php echo $employee->getFullName(); ?>
    </li>
  <?php endforeach; ?>
</div>
