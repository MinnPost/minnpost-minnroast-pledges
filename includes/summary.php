<section class="board">
	<div class="total-pledges">
		<strong>&#36;<?php echo number_format( $total ); ?></strong>
	</div>
	<?php if ( ! empty( $name ) ) : ?>
		<div class="name">
			<?php echo $name; ?>
		</div>
	<?php endif; ?>
</section>
