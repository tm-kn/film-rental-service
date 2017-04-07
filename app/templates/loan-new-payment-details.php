<div class="row">
  <div class="large-12 columns">
    <h1>Loan <?php echo $dvd->getFilmTitle(); ?> (#<?php echo $dvd->getId(); ?>) out</h1>
    <p class="lead">
      You are trying to loan that DVD to <?php echo $customer->getName(); ?> (#<?php echo $customer->getId(); ?>).
    </p>
    <h2>Payment - <?php echo $paymentType->getName(); ?></h2>
    <form
      action="<?php
        echo \Lib\url(
          '/loans/new/payment/details/',
          [
            'dvdid' => $dvd->getId(),
            'custid' => $customer->getId(),
            'paymenttype' => $paymentType->getId()
          ]
        );
      ?>"
      method="post"
    >
      <div class="row">
        <div class="large-12 columns">
          <label>
            Amount (GBP)
            <input
              type="number"
              required
              placeholder="Amount(GBP)"
              step="0.01"
              name="amount"
              value="<?php echo $request->getData('amount'); ?>"
            >
          </label>
        </div>
      </div>
      <?php switch ($paymentType->getId()): case 1: ?>
          <p>No additional information required for cash payment.</p>
        <?php break; ?>
        <?php case 2: ?>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Cheque number
                <input
                  placeholder="Cheque number"
                  required
                  type="text"
                  name="chequeno"
                  value="<?php echo $request->getData('chequeno'); ?>"
                >
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Bank number
                <input
                  placeholder="Bank number"
                  required
                  type="text"
                  name="bankno"
                  value="<?php echo $request->getData('bankno'); ?>"
                >
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Bank name
                <input
                  placeholder="Bank name"
                  required
                  type="text"
                  name="bankname"
                  value="<?php echo $request->getData('bankname'); ?>"
                >
              </label>
            </div>
          </div>
        <?php break;?>
        <?php case 3: ?>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Card number
                <input
                  placeholder="Card number"
                  required
                  type="text"
                  name="dcno"
                  value="<?php echo $request->getData('dcno'); ?>"
                >
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Card type
                <select name="dctype">
                  <?php foreach(['Switch', 'Maestro', 'Visa Electron'] as $cardType): ?>
                    <option
                      value="<?php echo $cardType; ?>"
                      <?php echo ($request->getData('dctype') == $cardType ?'selected' : ''); ?>
                    >
                      <?php echo $cardType; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-6 columns">
              <label>
                Expiry month
                <input
                  placeholder="Expiry month"
                  required
                  type="number"
                  name="expirymonth"
                  min="1"
                  max="12"
                >
              </label>
            </div>
            <div class="large-6 columns">
              <label>
                Expiry year
                <input
                  placeholder="Expiry year"
                  required
                  type="number"
                  name="expiryyear"
                  min="2017"
                  max="2050"
                >
              </label>
            </div>
          </div>
        <?php break; ?>
        <?php case 4: ?>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Card number
                <input
                  required
                  placeholder="Card number"
                  type="text"
                  name="ccno"
                  value="<?php echo $request->getData('ccno'); ?>"
                >
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>
                Card type
                <select name="cctype">
                  <?php foreach(['American Express', 'Visa', 'MasterCard'] as $cardType): ?>
                    <option
                      value="<?php echo $cardType; ?>"
                      <?php echo ($request->getData('cctype') == $cardType ?'selected' : ''); ?>
                    >
                      <?php echo $cardType; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="large-6 columns">
              <label>
                Expiry month
                <input
                  placeholder="Expiry month"
                  required
                  type="number"
                  name="expirymonth"
                  min="1"
                  max="12"
                >
              </label>
            </div>
            <div class="large-6 columns">
              <label>
                Expiry year
                <input
                  placeholder="Expiry year"
                  required
                  type="number"
                  name="expiryyear"
                  min="<?php echo date('Y'); ?>"
                >
              </label>
            </div>
          </div>
        <?php break; ?>
        <?php default: ?>
          <?php throw new \Exception('Payment type form for type ' . $paymentType->getId() . ' not implemented'); ?>
      <?php endswitch; ?>
      <div class="row">
        <div class="large-12 columns">
          <input class="button large success" type="submit" value="Pay">
          <span>or</span>
          <a
            href="
              <?php
                echo \Lib\url(
                  '/loans/new/payment/',
                  ['dvdid' => $dvd->getId(), 'custid' => $customer->getId()]
                );
              ?>
            "
            class="button alert"
          >
            Go back
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
