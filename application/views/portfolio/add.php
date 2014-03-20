<h1 style="text-align:center;">Add Project</h1><br/><br/>
<div class="container">
    <div class="row">
        <div class="span12">
            <form class="form-horizontal" method="post" action="<?= base_url('add/index') ?>" style="margin:auto;width:600px;">
				<div class="control-group">
					<label class="control-label" for="title">Title</label>
					<div class="controls">
						<input type="text" class="input-xlarge" maxlength="200" value="<?= set_value('title') ?>" placeholder="title" id="title" name="title" />
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
					<label class="control-label" for="description">Description</label>
					<div class="controls">
						<textarea class="input-xlarge" maxlength="" placeholder="description" id="description" name="description"><?= set_value('description') ?></textarea>
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="reference">Reference</label>
					<div class="controls">
						<input type="text" class="input-xlarge" maxlength="500" value="<?= set_value('reference') ?>" placeholder="reference" id="reference" name="reference" />
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="visible">Visible</label>
                    <div class="controls">
						<select class="input-xlarge" id="visible" name="visible">
							<option value="0" <?= set_select('visible', '0', true) ?>>Not Visible</option>
							<option value="1" <?= set_select('visible', '1') ?>>Visible</option>
						</select>
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="status">Status</label>
                    <div class="controls">
						<select class="input-xlarge" id="status" name="status">
							<option value="Complete" <?= set_select('status', 'Complete', true) ?>>Complete</option>
							<option value="Incomplete" <?= set_select('status', 'Incomplete') ?>>Incomplete</option>
						</select>
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="tags">Tags</label>
					<div class="controls">
						<ul class="inline" id="tags">
                            <li></li>
                        <?php if (isset($tags)): ?>
                            <?php foreach ((array) $tags as $tag): ?>
                                <li><?= $tag ?></li>
                            <?php endforeach ?>
                        <?php endif ?>
						</ul>
					</div>
				</div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="date_created">Date Created</label>
					<div class="controls">
						<input type="text" class="input-xlarge" value="<?= set_value('date_created') ?>" placeholder="date created" id="date_created" name="date_created" />
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
                    <label class="control-label" for="date_modified">Date Modified</label>
					<div class="controls">
						<input type="text" class="input-xlarge" value="<?= set_value('date_modified') ?>" placeholder="date modified" id="date_modified" name="date_modified" />
					</div>
                </div> <!-- /.control-group -->
                <div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div> <!-- /.control-group -->
			</div> <!-- /.span12 -->
        </form>
    </div> <!-- /.row -->
</div> <!-- /.container -->




