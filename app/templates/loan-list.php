<div class="row">
  <div class="large-12 columns">
    <div class="row">
      <div class="small-8 columns">
        <h1>DVDs on loan</h1>
      </div>
      <div class="small-4 columns">
        <a class="button large primary float-right" href="<?php echo \Lib\url('/loans/new/'); ?>">Loan out a DVD</a>
      </div>
    </div>
    <?php if(!count($loans)): ?>
      <div class="callout primary">
        <h5>No DVDs on loan</h5>
      </div>
    <?php else: ?>
      <table>
        <thead>
          <th>Film</th>
          <th>DVD</th>
          <th>Customer</th>
          <th>Due</th>
          <th>Rate</th>
          <th>Overdue Charge</th>
          <th>Status</th>
          <th>Details</th>
        </thead>
        <tbody>
          <?php foreach($loans as $loan): ?>
            <tr>
              <td>
                <?php echo $loan->getFilmName(); ?> (#<?php echo $loan->getFilmId(); ?>)
              </td>
              <td>
                #<?php echo $loan->getDvdId(); ?>
              </td>
              <td>
                <?php echo $loan->getCustomerName();  ?> (#<?php echo $loan->getCustomerId(); ?>)
              </td>
              <td>
                <?php echo $loan->getDueDate(); ?>
              </td>
              <td>
                £<?php echo $loan->getRate(); ?>
              </td>
              <td>
                £<?php echo $loan->getOverdueCharge(); ?>
              </td>
              <td>
                <?php echo $loan->getStatus(); ?>
              </td>
              <td>
                <a href="<?php echo \Lib\url('/loans/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $loan->getReturnDateTime()]); ?>">
                  details
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
