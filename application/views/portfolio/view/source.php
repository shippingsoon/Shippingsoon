<?php if (!empty($files) AND $owner == 'Shipping Soon'): ?>
			<div class="panel-group article-accordion accordion" id="source-accordion">
<?php $index = 0; foreach ($files AS $file): ?>
<?php if ($file['content']): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#source-accordion" href="#collapse-<?= $index ?>" title="Click to toggle">
								<i class="fa fa-file-text"></i> <?= $file['filename'] ?>
							</a>
						</h4>
					</div> <!-- /.panel-heading -->
					<div id="collapse-<?= $index ?>" class="panel-collapse collapse <?php if ($index == 0):?>in<?php endif ?>">
						<div class="panel-body">
							<pre class="prettyprint linenums"><?= $file['content'] ?></pre>
						</div>
					</div> <!-- /#collapse-<?= $index ?> .panel-collapse .collapse  <?php if ($index++ == 0):?>.in<?php endif ?>-->
				</div> <!-- /.panel panel-default -->
<?php endif ?>
<?php endforeach ?>
			</div> <!-- /#source-accordion .panel-group -->
			<br/>
<?php endif ?>

