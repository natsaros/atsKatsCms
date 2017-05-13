<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$posts = PostFetcher::fetchAllPosts();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /* @var $post Post */
                foreach ($posts as $key => $post) {
                    $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                    $postId = $post->getID();
                    ?>
                    <tr class="<?php echo $oddEvenClass ?>">
                        <td><?php echo $postId; ?></td>
                        <td><?php echo $post->getTitle(); ?></td>
                        <td><?php echo $post->getActivationDate(); ?></td>
                        <td>
                            <?php
                            //Opposite set to '$updatedStatus' so that this gets passed to the db
                            $updatedStatus = $post->getState() ? 0 : 1;
                            $activDeactivText = $post->getState() ? 'Deactivate' : 'Activate';
                            ?>

                            <a type="button"
                               href="<?php echo sprintf(getAdminActionRequestUri() . "post" . DS . "updatePostStatus?id=%s&status=%s", $postId, $updatedStatus); ?>"
                               class="btn btn-default btn-sm" title="<?php echo $activDeactivText ?> Post">
                                <?php $statusClass = $post->getState() ? 'text-success' : 'text-danger' ?>
                                <span class="glyphicon glyphicon-comment <?php echo $statusClass ?>"
                                      aria-hidden="true"></span>
                            </a>

                            <a type="button"
                               href="<?php echo sprintf(getAdminActionRequestUri() . "post" . DS . "deletePost?id=%s", $postId); ?>"
                               class="btn btn-default btn-sm" title="Delete Post">
                                <span class="glyphicon glyphicon-erase" aria-hidden="true"></span>
                            </a>

                            <a type="button"
                               href="<?php echo sprintf(getAdminRequestUri() . "updatePost?id=%s", $postId); ?>"
                               class="btn btn-default btn-sm" title="Edit Post">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <a href="<?php echo getAdminRequestUri() . "updatePost"; ?>" type="button" class="btn btn-outline btn-primary">
            Add <span class="fa fa-comment fa-fw" aria-hidden="true"></span>
        </a>
    </div>
</div>