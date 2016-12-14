<?php require("pageHeader.php"); ?>

<?php $users = UserFetcher::fetchUsers(); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Available Users
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>E-mail</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /* @var $user User */
                    foreach($users as $key => $user) {
                        $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                        ?>
                        <tr class="<?php echo $oddEvenClass ?>">
                            <td><?php echo $user->getID(); ?></td>
                            <td><?php echo $user->getUserName(); ?></td>
                            <td><?php echo $user->getFirstName(); ?></td>
                            <td><?php echo $user->getLastName(); ?></td>
                            <td><?php echo $user->getEmail(); ?></td>
                            <td>
                                <button type="button" class="btn btn-default btn-sm" title="Status">
                                    <?php $statusClass = $user->getUserStatus() ? 'text-success' : 'text-danger' ?>
                                    <span class="glyphicon glyphicon-user <?php echo $statusClass ?>"
                                          aria-hidden="true"></span>
                                </button>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>