<h1><?= $title; ?></h1>
<hr>
<div class="jumbotron text-center">
<p><?= $body; ?></p>
<br/>
<p>Date Create : <strong><?= $date; ?></strong></p>
<?php if($this->session->logged_in == true && $this->session->access == 1) {?>
</div>
<div class="btn-group">
    <a href="edit/<?=$id;?>" class="btn btn-primary">Edit</a>
    <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Delete</button>
</div>
<?php } ?>