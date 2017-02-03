<h1><?php echo $loan->getFilmName(); ?> (DVD #<?php echo $loan->getDvdId(); ?>) <small>Accept Return</small></h1>
<p class="lead">Do you really want to accept return of this DVD?</p>

<form method="post" action="<?php echo \Lib\url('/loans/accept-return/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $loan->getReturnDateTime()]); ?>">
  <div class="row">
    <div class="large-12 columns">
      <input class="button large success" type="submit" value="Yes, accept the return">
      <span>or</span>
      <a href="<?php echo \Lib\url('/loans/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $loan->getReturnDateTime()]); ?>" class="button alert">No, go back</a>
    </div>
  </div>
</form>
