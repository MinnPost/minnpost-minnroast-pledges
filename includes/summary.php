<?php
$count = $result->fetchColumn();
?>

<div class="total-pledges">
  <div><strong><?php echo $count; ?></strong> pledges &mdash; &#36;<?php echo number_format($total); ?></div>
</div>