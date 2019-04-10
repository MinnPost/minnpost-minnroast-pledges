<section class="board">
	<div class="total-pledges">
		<strong><?php echo $count; ?></strong> <?php echo $word; ?> &mdash; &#36;<?php echo number_format( $total ); ?>
	</div>
	<?php if ( ! empty( $name ) ) : ?>
		<div class="name">
			<?php echo $name; ?>
		</div>
	<?php endif; ?>
</section>
