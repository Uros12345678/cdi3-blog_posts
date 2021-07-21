<h1><?= $title; ?></h1>
<hr>
<?= validation_errors(); ?>
<div class="row">
    <div class="col-lg-12">

        <?= form_open('add');?>
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Enter post title" value="<?= set_value('title');?>">
            </div>
            <br/>
            <div class="form-group">
                <textarea name="body" id="" cols="30" rows="5" class="form-control" placeholder="Enter post details"><?= set_value('body');?></textarea>
            </div>
            
            <button type="submit" name="submit" class="btn btn-success">Submit</button>
        <!-- form-close -->

    </div>
</div>