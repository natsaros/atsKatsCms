<!--Modal Header-->
<?php $id = $_GET['id'] ?>
<?php $modalTitle = $_GET['modalTitle'] ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel_<?php echo $id ?>"><?php echo $modalTitle?></h4>
</div>
