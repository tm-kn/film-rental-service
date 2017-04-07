<div class="row">
  <div class="large-12 columns">
    <h1>Loan <?php echo $dvd->getFilmTitle(); ?> (#<?php echo $dvd->getId(); ?>) out</h1>
    <p class="lead">
      You are trying to loan that DVD to <?php echo $customer->getName(); ?> (#<?php echo $customer->getId(); ?>).
    </p>
    <h2>Payment</h2>
    <form
      action="<?php
        echo \Lib\url(
          '/loans/new/payment/',
          ['dvdid' => $dvd->getId(), 'custid' => $customer->getId()]);
      ?>"
      method="post"
    >
      <div class="row">
        <div class="large-12 columns">
          <label>
            Payment type
            <select name="paymenttype">
              <?php foreach ($paymentTypes as $type): ?>
                <option value="<?php echo $type->getId(); ?>">
                  <?php echo $type->getName(); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>
        </div>
      </div>
      <div class="row">
        <div class="large-12 columns">
          <input class="button large success" type="submit" value="Proceed">
          <span>or</span>
          <a href="<?php echo \Lib\url('/loans/new/');?>" class="button alert">Go back</a>
        </div>
      </div>
    </form>
  </div>
</div>
