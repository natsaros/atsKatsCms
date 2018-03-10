<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$promotions = PromotionHandler::getAllPromotions();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
                <thead>
                <tr>
                    <th>Instance</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Promotion Text</th>
                    <th>Times Seen</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!is_null($promotions) && count($promotions) > 0) {
                    foreach($promotions as $key => $promotion) {
                        $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                        $promotionId = $promotion->getID();
                        ?>
                        <tr class="<?php echo $oddEvenClass ?>">
                            <td><?php echo $promotion->getPromotedInstance()->getTitle(); ?></td>
                            <td><?php echo $promotion->getPromotedFrom(); ?></td>
                            <td><?php echo $promotion->getPromotedTo(); ?></td>
                            <td><?php echo $promotion->getPromotionText(); ?></td>
                            <td><?php echo $promotion->getTimesSeen(); ?></td>
                            <td>

                                <a type="button"
                                   href="<?php echo getAdminActionRequestUri() . "promotions" . DS . "deletePromotion" . addParamsToUrl(array('id'), array($promotionId)); ?>"
                                   class="btn btn-default btn-sm" title="Delete Promotion">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>

                                <a type="button"
                                   href="<?php echo getAdminRequestUri() . "updatePromotion" . addParamsToUrl(array('id'), array($promotionId)); ?>"
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
        <a href="<?php echo getAdminRequestUri() . "updatePromotion"; ?>" type="button" class="btn btn-outline btn-primary">
            Add <span class="fa fa-plus fa-fw" aria-hidden="true"></span>
        </a>
    </div>
</div>