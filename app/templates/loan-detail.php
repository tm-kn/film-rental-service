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
<div class="row">
  <div class="large-12 columns">
    <h2>Associated Transactions</h2>
    <?php if (count($payments)): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Employee</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($payments as $payment): ?>
            <tr>
              <td><?php echo $payment->getId(); ?></td>
              <td><?php echo $payment->getAmount(); ?></td>
              <td><?php echo $payment->getDateTime(); ?></td>
              <td><?php echo $payment->getEmployeeName(); ?> (<?php echo $payment->getEmployeeNiNumber(); ?>)</td>
              <td><?php echo $payment->getCustomerName(); ?> (<?php echo $payment->getCustomerId(); ?>)</td>
              <td><?php echo $payment->getPaymentStatus(); ?></td>
              <td><?php echo $payment->getPaymentType(); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="callout">
        <p>There is no transactions associated with this loan.</p>
      </div>
    <?php endif; ?>
  </div>
</div>
