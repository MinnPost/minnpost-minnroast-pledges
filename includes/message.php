<section>
	<h3 class="component-label">Thank you for supporting MinnPost's 2016 election coverage!</h3>
	<p>We have received your pledge of <strong>&#36;<?php echo $amount; ?></strong>, under the email address <strong><?php echo $email; ?></strong>.</p>
	<?php if ($charge_if_on_file === 1) { ?>
	<p>Early next week, we will attempt to charge your credit card on file. You will get a receipt email at that address if it is successful. We'll be in touch to fulfill your pledge if it is not on file.</p>
	<?php } else { ?>
	<p>Early next week, we will email you at that address with options on how to fullfill your pledge.</p>
	<?php } ?>
</section>