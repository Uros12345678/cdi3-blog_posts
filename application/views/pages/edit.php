<?php if($this->session->flashdata('post_updated')): ?>
    <?= '<p class="alert alert-success">'.$this->session->flashdata('post_updated').'</p>'; ?>
<?php endif; ?>

<h1><?= $title; ?></h1>
<hr>
<?= validation_errors(); ?>
<div class="row">
    <div class="col-lg-12">

        <?= form_open('edit/'.$id);?>
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Enter post title" value="<?= $title;?>">
            </div>
            <br/>
            <div class="form-group">
                <textarea name="body" id="" cols="30" rows="5" class="form-control" placeholder="Enter post details"><?= $body;?></textarea>
            </div>
            <input type="hidden" name="id" value="<?= $id;?>">
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <!-- form-close -->

    </div>
</div>