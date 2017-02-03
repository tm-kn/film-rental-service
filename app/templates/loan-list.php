<div class="row">
  <div class="large-12 columns">
    <h1>DVDs on loan</h1>
    <?php if(!count($loans)): ?>
      <div class="callout primary">
        <h5>No DVDs on loan</h5>
      </div>
    <?php else: ?>
      <ul>
        <?php foreach($loans as $loan): ?>
          <li>
            <?php echo $loan->getShopId(); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>
