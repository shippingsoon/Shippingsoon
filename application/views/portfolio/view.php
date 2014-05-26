<div class="container portfolio-container">
	<div class="row">
		<div class="col-md-8">
<?php if (!empty($images)): ?>
			<div id="portfolio-carousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
<?php for($i = 0; $i < count($images); $i++): ?>
					<li data-target="#portfolio-carousel" data-slide-to="<?= $i ?>" class="<?php if ($i == 0): ?>active<?php endif ?>"></li>
<?php endfor ?>
				</ol> <!-- /.carousel-indicators -->
				<div class="carousel-inner">
<?php foreach ($images AS $key => $image): ?>
					<div class="item <?php if ($key == 3): ?>active<?php endif ?>">
						<a class="fancybox" href="<?= base_url("uploads/articles/img/$article_id/$image") ?>" title="<?= $title ?>">
							<img class="img-responsive" src="<?= base_url("uploads/articles/img/$article_id/$image") ?>" alt="">
						</a>
						<div class="carousel-caption"></div>
					</div> <!-- /.item -->
<?php endforeach ?>
				</div> <!-- /.carousel-inner -->
				<a class="left carousel-control" href="#portfolio-carousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#portfolio-carousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div> <!-- /#portfolio-carousel .carousel .slide -->
<?php endif ?>
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
		</div> <!-- /.col-md-8 -->
