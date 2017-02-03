<h1>Log in</h1>
<p class="lead">Type your NIN number in order to authenticate.</p>

<form action="<?php echo \Lib\url('/login/'); ?>" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>National Insurance Number
        <input name="empnin" type="text">
      </label>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <input class="button primary" type="submit" value="Submit">
    </div>
  </div>
</form>
