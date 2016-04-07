<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <section>
        <h3 class="component-label">Your Pledge</h3>
        <div class="form-item">
            <label>Email address
              <input type="email" autocapitalize="off" autocorrect="off" name="email" id="email" value="<?php echo $email; ?>" required="required">
            </label>
        </div>

        <div class="form-item">
            <label>Amount <span class="currencyinput">$</span>
              <input type="number" value="<?php echo $amount; ?>" name="amount" id="amount" required="required" min="1" step="any">
            </label>
        </div>

        <div class="form-item checkbox">
            <label>Charge card if MinnPost has it on file
              <input type="checkbox" name="charge_if_on_file" id="charge_if_on_file" value="1">
            </label>
        </div>

    </section>

    <button class="button primary" type="submit">Send Your Pledge</button>

</form>