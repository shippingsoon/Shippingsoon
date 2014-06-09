<?php if ($description): ?>
			<p><b>Synopsis</b>: <?= $description ?></p>
<?php endif ?>
<?php if ($license): ?>
			<p><b>License</b>: <?= $license ?></p>
<?php endif ?>
<?php if ($owner): ?>
			<p><b>Company</b>: <?= $owner ?></p>
<?php endif ?>
<?php if ($source_link): ?>
			<p><b>Source Code:</b> <a href="<?= $source_link ?>" title="<?= $source_link ?>" target="_blank"><?= $source_link ?></a></p>
<?php endif ?>
<?php if ($live_link): ?>
			<p><b>Link:</b> <a href="<?= $live_link ?>" title="<?= $live_link ?>" target="_blank"><?= $live_link ?></a></p>
<?php endif ?>
