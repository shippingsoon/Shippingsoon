<h1 class="page_title">Project</h1><br/><br/>

<div class="container projects">
	<div class="row">
		<div class="span5 offset7">
			<form id="project_form" class="<?= $method ?>" action="<?= base_url("project/find/$offset") ?>" method="post">
				<input type="hidden" id="offset" value="<?= $offset ?>"/>
				<input type="hidden" id="limit" value="<?= $limit ?>"/>
				<input type="hidden" id="auto_complete" value="<?= $auto_complete ?>"/>
				<div class="pull-right" id="search-icon">
					<button><i class="icon-search"></i></button>
				</div>
				<input id="search_query" value="<?= !empty($tags) ? implode(',', $tags) : '' ?>" name="tags" type="text" placeholder="search for projects (e.g., c++, web)"/>
			</form>
		</div> <!-- /.span5  -->
	</div> <!-- /.row --> 
	<ul class="thumbnails grid" style="margin-top:20px;">
	<?php if (!empty($projects)): ?>
		<?php foreach ($projects AS $project): ?>
		<li class="span3">
			<div class="thumbnail">
				<a href="<?= $project['details_link'] ?>" class="image-holder details_link" title="<?= $project['title'] ?>">
					<img src="<?= $project['image_path'] ?>" class="image_path" alt="<?= $project['title'] ?>"/>
				</a>
				<h3>
					<a href="<?= $project['details_link'] ?>" class="details_link title" title="<?= "{$project['title']} {$project['version']}" ?>"><?= "{$project['title']} {$project['version']}" ?></a>
				</h3>
				<p style="text-align:center;" class="description">
					<?= $project['description'] ?><br/>
					<div class="maintenance" style="text-align:center;">
					<?php if ($logged_in): ?>
						<a href="<?= $project['details_link'] ?>" class="btn btn-small" title="View <?= $project['title'] ?>">View</a>
						<a href="<?= $project['edit_link'] ?>" class="btn btn-inverse btn-small" style="color:white;" title="Edit <?= $project['title'] ?>">Edit</a>
					<?php endif ?>
					</div>
				</p>
			</div>
		</li> <!-- /.span4 -->
		<?php endforeach ?>
	<?php else: ?>
		<li class="span12"><h3>No projects found<h3></li>
	<?php endif ?>
	</ul> <!-- /.thumbnails -->
	<ul class="template hide">
		<li class="span3">
			<div class="thumbnail">
				<a href="" class="image-holder details_link" title="">
					<img class="image_path" alt=""/>
				</a>
				<h3>
					<a href="" class="details_link title" title=""></a>
				</h3>
				<p style="text-align:center;" class="description">
					<div class="maintenance" style="text-align:center;"></div>
				</p>
			</div>
		</li> <!-- /.span4 -->
	</ul> <!-- /.thumbnails -->
	<div class="row">
		<?php /*
		<div class="span1">
			<div class="btn-group pull-right toggle-views" data-toggle="buttons-radio">
				<button type="button" class="btn  thumb-btn <?php if (!$show_table): ?>active<?php endif ?>"><i class="icon-th"></i></button>
				<button type="button" class="btn list-btn <?php if ($show_table): ?>active<?php endif ?>"><i class="icon-list"></i></button>
			</div>
		</div> <!-- /.span1 -->
		*/ ?>
		<div class="span2 offset10">
			<div class="btn-group project_pager">
				<?= isset($pager_links) ? $pager_links : '' ?>
			</div>
		</div> <!-- /.span5  -->
	</div> <!-- /.row -->
</div> <!-- /.container .projects -->
