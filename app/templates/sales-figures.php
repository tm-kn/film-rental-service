<div class="row">
  <div class="12-large columns">
    <h1>Daily Sales Figures</h1>
    <table>
      <tbody>
        <tr>
          <td>Total payments today (GBP)</td>
          <td>£ <?php echo $totalPaymentsToday; ?></td>
        </tr>
        <tr>
          <td>Number of DVDs rented today</td>
          <td><?php echo $dvdsRentedToday; ?></td>
        </tr>
        <tr>
          <td>Number of DVDs returned today</td>
          <td><?php echo $dvdsReturnedToday; ?></td>
        </tr>
        <tr>
          <td>Employee with most transactions today</td>
          <td>
            <?php if ($mostTransactionsEmployeeToday): ?>
              <?php
                echo $mostTransactionsEmployeeToday->getFullName();
              ?> (<?php
                echo $mostTransactionsEmployeeToday->getTodayTransactions();
              ?> transactions today)
            <?php endif; ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>
