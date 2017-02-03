<h1>Loan out a DVD</h1>
<p class="lead">Type the DVD's identification number or choose it from the list.</p>

<form method="post" action="<?php echo \Lib\url('/loans/'); ?>">
  <div class="row">
    <div class="large-6 columns">
      <label>DVD identification number
        <input type="text" name="dvdid" value="<?php echo $request->getData('dvdid'); ?>">
      </label>
    </div>
    <div class="large-6 columns">
      <label>Customer identification number
        <input type="text" name="custid" value="<?php echo $request->getData('custid'); ?>">
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <input class="button large success" type="submit" value="Yes, procced with the loan">
      <span>or</span>
      <a href="<?php echo \Lib\url('/loans/');?>" class="button alert">Cancel</a>
    </div>
  </div>
</form>
