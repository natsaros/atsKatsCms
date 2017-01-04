<?php require("pageHeader.php"); ?>

<?php $currentUser = UserFetcher::getUserById($_GET["id"]); ?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Info
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form">
                            <div class="form-group">
                                <label>User Name</label>
                                <input class="form-control" placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" placeholder="First Name">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
