<h1><?php echo $loan->getFilmName(); ?></h1>
<div class="row">
  <div class="medium-6 columns">
    <dl>
      <dt>DVD ID</dt>
      <dd><?php echo $loan->getDvdId(); ?></dd>

      <dt>Customer</dt>
      <dd><?php echo $loan->getCustomerName(); ?> (#<?php echo $loan->getCustomerId(); ?>)</dd>

      <dt>Film</dt>
      <dd><?php echo $loan->getFilmName(); ?> (#<?php echo $loan->getFilmId(); ?>)</dd>

      <dt>Due</dt>
      <dd><?php echo $loan->getDueDate(); ?></dd>

      <dt>Returned</dt>
      <dd><?php echo $loan->getReturnDateTime(); ?></dd>

      <dt>Rate</dt>
      <dd>£<?php echo $loan->getRate(); ?></dd>

      <dt>Overdue charge</dt>
      <dd>£<?php echo $loan->getOverdueCharge(); ?></dd>

      <dt>Status</dt>
      <dd><?php echo $loan->getStatus(); ?></dd>
    </dl>
  </div>
  <div class="medium-6 columns">
    <?php if($loan->getStatusId() != 2): ?>
      <a class="button large primary" href="<?php echo \Lib\url('/loans/accept-return/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $loan->getReturnDateTime()]); ?>">
        Accept return
      </a>
    <?php endif; ?>
  </div>
</div>
