<?php if ($pages): ?>
				<article class="blog-entry">
					<?= str_replace('\t', "\t", $pages[0]['content']) ?>
				</article> <!-- /.blog-entry -->
<?php endif ?>
