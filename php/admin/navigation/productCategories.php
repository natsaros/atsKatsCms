<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$productCategories = ProductCategoryHandler::fetchAllProductCategories();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!is_null($productCategories) && count($productCategories) > 0) {
                    foreach ($productCategories as $key => $productCategory) {
                        $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                        $productCategoryId = $productCategory->getID();
                        ?>
                        <tr class="<?php echo $oddEvenClass ?>">
                            <td><?php echo $productCategoryId; ?></td>
                            <td><?php echo $productCategory->getTitle(); ?></td>
                            <td><?php echo $productCategory->getDescription(); ?></td>
                            <td>
                                <?php
                                //Opposite set to '$updatedStatus' so that this gets passed to the db
                                $updatedStatus = $productCategory->getState() ? 0 : 1;
                                $activDeactivText = $productCategory->getState() ? 'Deactivate' : 'Activate';
                                ?>

                                <a type="button"
                                   href="<?php echo getAdminActionRequestUri() . "productCategories" . DS . "updateProductCategoryStatus" . addParamsToUrl(array('id', 'status'), array($productCategoryId, $updatedStatus)); ?>"
                                   class="btn btn-default btn-sm"
                                   title="<?php echo $activDeactivText ?> Product Category">
                                    <?php $statusClass = $productCategory->getState() ? 'active-item' : 'inactive-item' ?>
                                    <span class="glyphicon glyphicon-comment <?php echo $statusClass ?>"
                                          aria-hidden="true"></span>
                                </a>

                                <a type="button"
                                   href="<?php echo getAdminActionRequestUri() . "productCategories" . DS . "deleteProductCategory" . addParamsToUrl(array('id'), array($productCategoryId)); ?>"
                                   class="btn btn-default btn-sm" title="Delete Product Category">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>

                                <a type="button"
                                   href="<?php echo getAdminRequestUri() . "updateProductCategory" . addParamsToUrl(array('id'), array($productCategoryId)); ?>"
                                   class="btn btn-default btn-sm" title="Edit Product Category">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <a href="<?php echo getAdminRequestUri() . "updateProductCategory"; ?>" type="button" class="btn btn-outline btn-primary">
            Add <span class="fa fa-comment fa-fw" aria-hidden="true"></span>
        </a>
    </div>
</div>