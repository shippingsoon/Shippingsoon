<div class="wrapper tmp">
	<div class="container">
	</div> <!-- /.container -->
</div> <!-- ./wrapper -->

<div class="container">
	<div class="row project-entry">
		<div class="col-md-8">
			<h3 class="project-title"><?= "$title $version" ?> <?php if ($logged_in): ?><a href="<?= $edit_link ?>" class="btn btn-inverse" title="Edit <?= $title ?>">Edit</a><?php endif ?></h3>
			<p class="project-created">Date Created: <?= $date_created ?></p>
<?php if ($has_image): ?>
			<a href="<?= $image_path ?>" class="fancybox" title="<?= $title ?>">
				<img src="<?= $image_path ?>" class="project-image img-responsive" alt="<?= $title ?>"/>
			</a>
			<br/><br/>
<?php endif ?>
		<?php if ($has_file AND $owner == 'Shippingsoon'): ?>
			<div class="panel-group project-accordion" id="source-accordion">
			<?php $index = 0; foreach ($files AS $file): ?>
				<?php if ($file['supported']): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#source-accordion" href="#collapse-<?= $index ?>">
								<i class="fa fa-file-text"></i> <?= $file['info']['basename'] ?>
							</a>
						</h4>
					</div> <!-- /.panel-heading -->
					<div id="collapse-<?= $index ?>" class="panel-collapse collapse <?php if ($index == 0):?>in<?php endif ?>">
						<div class="panel-body">
							<pre class="brush: <?= $file['info']['extension'] ?>">
								<?= $file['content'] ?>
							</pre>
						</div>
					</div> <!-- /#collapse-<?= $index ?> .panel-collapse .collapse  <?php if ($index++ == 0):?>.in<?php endif ?>-->
				</div> <!-- /.panel panel-default -->
				<?php endif ?>
			<?php endforeach ?>
			</div> <!-- /#source-accordion .panel-group -->
			<br/>
		<?php endif ?>
<?php if ($description): ?>
			<p><b>Synopsis</b>: <?= $description ?></p>
<?php endif ?>
<?php if ($description): ?>
			<p><b>Date Created</b>: <?= $date_created ?></p>
<?php endif ?>
<?php if ($reference): ?>
			<p><b>Reference</b>: <?= $reference ?></p>
<?php endif ?>
<?php if ($license): ?>
			<p><b>License</b>: <?= $license ?></p>
<?php endif ?>
<?php if ($indention_style): ?>
			<p><b>Indent Style</b>: <?= $indention_style ?></p>
<?php endif ?>
			<p><b>Status</b>: <?= $status ?></p>
<?php if ($owner != 'Shippingsoon'): ?>
			<p><b>Owner</b>: <?= $owner ?></p>
<?php endif ?>
<?php if ($link): ?>
			<p><a href="<?= $link ?>" title="<?= $link ?>" target="_blank"><?= $link ?></a></p>
<?php endif ?>
		</div> <!-- /.col-md-8 -->
		<div class="col-md-4 sidebar">
			<h3><i class="icon-tag"></i> Recent Projects</h3>
			<div class="recent-projects">
<?php foreach ($recent_projects AS $recent_project): ?>
				<a class="pull-left" href="<?= $recent_project['details_link'] ?>">
					<img src="<?= $recent_project['image_path'] ?>" class="img-responsive" alt="<?= $title ?>"/>
				</a>
				<div class="pull-right">
					<a href="<?= $recent_project['details_link'] ?>" title="<?= "{$recent_project['title']} {$recent_project['version']}" ?>" class="title"><?= "{$recent_project['title']} {$recent_project['version']}" ?></a><br/>
					<a href="<?= $recent_project['details_link'] ?>" title="<?= $recent_project['title'] ?>" class="muted"><?= $recent_project['description'] ?></a>
				</div>
				<div style="clear:both"></div><br/>
<?php endforeach ?>
			</div>
			<div class="tagcloud">
				<h3><i class="icon-cloud"></i> Tag Cloud</h3>
<?php foreach (explode(',', $tags) AS $tag): ?>
				<a href="<?= base_url('project/find/0/12/'.urlencode($tag)) ?>" title="<?= str_replace('_', ' ', $tag) ?>" rel="<?= rand(1, 40) ?>"><?= str_replace('_', ' ', $tag) ?></a>
<?php endforeach ?>
			</div>
		</div> <!-- /.col-md-4 -->
	</div> <!-- /.row -->
</div> <!-- /.container -->

