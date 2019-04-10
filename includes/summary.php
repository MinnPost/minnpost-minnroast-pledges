<section class="board">
	<div class="total-pledges">
		<?php if ( true === $board_show_count ) : ?>
			<strong><?php echo $count; ?></strong> <?php echo $word; ?> &mdash; &#36;<?php echo number_format( $total ); ?>
		<?php else : ?>
			<strong>&#36;<?php echo number_format( $total ); ?></strong>
		<?php endif; ?>
	</div>
	<?php if ( ! empty( $name ) && true === $board_show_names ) : ?>
		<div class="name">
			<?php echo $name; ?>
		</div>
	<?php endif; ?>
</section>
