<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$products = ProductHandler::fetchAllProductsWithDetails();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover products-dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!is_null($products) && count($products) > 0) {
                    foreach($products as $key => $product) {
                        $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                        $productId = $product->getID();
                        ?>
                        <tr class="<?php echo $oddEvenClass ?>">
                            <td><?php echo $productId; ?></td>
                            <td><?php echo $product->getCode(); ?></td>
                            <td><?php echo $product->getTitle(); ?></td>
                            <td><?php echo $product->getDescription(); ?></td>
                            <td>
                                <?php
                                //Opposite set to '$updatedStatus' so that this gets passed to the db
                                $updatedStatus = $product->getState() ? 0 : 1;
                                $activDeactivText = $product->getState() ? 'Deactivate' : 'Activate';
                                ?>

                                <a type="button"
                                   href="<?php echo getAdminActionRequestUri() . "products" . DS . "updateProductStatus" . addParamsToUrl(array('id', 'status'), array($productId, $updatedStatus)); ?>"
                                   class="btn btn-default btn-sm" title="<?php echo $activDeactivText ?> Product Category">
                                    <?php $statusClass = $product->getState() ? 'active-item' : 'inactive-item' ?>
                                    <span class="glyphicon glyphicon-comment <?php echo $statusClass ?>"
                                          aria-hidden="true"></span>
                                </a>

                                <a type="button"
                                   href="<?php echo getAdminActionRequestUri() . "products" . DS . "deleteProduct" . addParamsToUrl(array('id'), array($productId)); ?>"
                                   class="btn btn-default btn-sm" title="Delete Product">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>

                                <a type="button"
                                   href="<?php echo getAdminRequestUri() . "updateProduct" . addParamsToUrl(array('id'), array($productId)); ?>"
                                   class="btn btn-default btn-sm" title="Edit Product">
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
        <a href="<?php echo getAdminRequestUri() . "updateProduct"; ?>" type="button" class="btn btn-outline btn-primary">
            Add <span class="fa fa-shopping-cart fa-fw" aria-hidden="true"></span>
        </a>
    </div>
</div>