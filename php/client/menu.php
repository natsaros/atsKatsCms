<?php
if (isset($_GET["category_friendly_url"])) {
    $productCategory = ProductCategoryHandler::getProductCategoryByFriendlyTitle($_GET["category_friendly_url"]);
} else {
    $productCategory = null;
}
?>
<nav class="navbar navbar-default navbar-first">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 languages-container">
                <div class="language-container" id="languageSelector">
                    <span><?php if($_SESSION['locale'] == 'el_GR') { ?>ΕΛ<?php } else { ?>EN<?php } ?></span>
                    <a href="javascript:void(0);">
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul id="languagesContainer" class="alternative-language-container">
                        <li id="<?php if($_SESSION['locale'] == 'el_GR') { ?>en_US<?php } else { ?>el_GR<?php } ?>"><?php if($_SESSION['locale'] == 'el_GR') { ?>EN<?php } else { ?>ΕΛ<?php } ?></li>
                    </ul>
                </div>
                <?php $action = getClientActionRequestUri() . "changeLanguage"; ?>
                <form id="changeLanguageForm" action="<?php echo $action ?>" method="post">
                    <input type="hidden" id="currentURL" name="currentURL" value=""/>
                    <input type="hidden" id="language" name="language" value=""/>
                </form>
            </div>
            <div class="col-xs-6 social-icons-container">
                <a href="https://www.facebook.com/Sellinofos/" target="_blank" title="Sellinofos @ Facebook"><i class="fa fa-header-social-icon fa-facebook"></i></a>
                <a href="https://www.instagram.com/sellinofos/" target="_blank" title="Sellinofos @ Instagram"><i class="fa fa-header-social-icon fa-instagram"></i></a>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-default navbar-second">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo REQUEST_URI ?>home">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="<?php if($pageId == "home") { ?>active<?php } ?>"><a href="<?php echo REQUEST_URI ?>home"><?php if($_SESSION['locale'] == 'el_GR') { ?>Αρχική<?php } else { ?>Home<?php } ?></a>
                </li>
                <li class="<?php if($pageId == "collections" || isUnderProductCategoriesPath()) { ?>active <?php } ?>sub-category-menu-trigger">
                    <a href="<?php echo REQUEST_URI ?>collections">Collections</a>
                    <?php
                    $productCategories = ProductCategoryHandler::fetchAllActiveParentProductCategoriesForMenu();
                    if (!is_null($productCategories) && count($productCategories) > 0){
                        ?>
                            <?php
                            foreach($productCategories as $key => $pc) {
                                ?>
                                <div submenu="sub-menu-trigger-<?php echo $pc->getFriendlyTitle();?>" class="sub-menu-item mobile">
                                    <a class="sub-category-menu-link-inner-mobile<?php if (!is_null($productCategory) && $productCategory->getID() == $pc->getID()) { ?> active<?php } ?>" href="<?php echo getProductCategoriesUri() . $pc->getFriendlyTitle();?>">
                                        <span><?php echo $pc->getLocalizedTitle();?></span>
                                    </a>
<!--                                    <div class="sub-menu" submenuid="sub-menu---><?php //echo $pc->getFriendlyTitle();?><!--" style="display: none;">-->
<!---->
<!--                                        --><?php
//                                        foreach($pc->getChildrenCategories() as $key => $childProductCategory) {
//                                            ?>
<!--                                            <div>-->
<!--                                                <a href="--><?php //echo getProductCategoriesUri() . $childProductCategory->getFriendlyTitle();?><!--" class="sub-menu-link-inner-mobile--><?php //if (!is_null($productCategory) && $productCategory->getID() == $childProductCategory->getID()) { ?><!-- active--><?php //} ?><!--">-->
<!--                                                    <span>--><?php //echo $childProductCategory->getTitle();?><!--</span>-->
<!--                                                </a>-->
<!--                                            </div>-->
<!--                                            --><?php
//                                        }
//                                        ?>
<!--                                    </div>-->
                                </div>
                                <?php
                            }
                            ?>
                        <?php
                    }
                    ?>
                </li>
                <li class="<?php if (!is_null($productCategory) && $productCategory->getFriendlyTitle() == 'Sales') {?> active<?php } ?>"><a href="<?php echo REQUEST_URI ?>sales"><?php if($_SESSION['locale'] == 'el_GR') { ?>Εκπτώσεις<?php } else { ?>Sales<?php } ?></a>
                </li>
                <li class="<?php if($pageId == "contact") { ?>active<?php } ?>"><a href="<?php echo REQUEST_URI ?>contact"><?php if($_SESSION['locale'] == 'el_GR') { ?>Επικοινωνία<?php } else { ?>Contact<?php } ?></a>
                </li>
            </ul>
            <?php
            if (!is_null($productCategories) && count($productCategories) > 0){
                ?>
                <ul class="sub-category-menu" style="display: none;">

                    <?php
                    foreach($productCategories as $key => $pc) {
                        ?>
                        <li submenu="sub-menu-trigger-<?php echo $pc->getFriendlyTitle();?>">
                            <a  class="sub-category-menu-link-inner<?php if (!is_null($productCategory) && $productCategory->getID() == $pc->getID()) { ?> active<?php } ?>" href="<?php echo getProductCategoriesUri() . $pc->getFriendlyTitle();?>">
                                <span><?php echo $pc->getLocalizedTitle();?></span>
                            </a>
                            <div class="sub-menu" submenuid="sub-menu-<?php echo $pc->getFriendlyTitle();?>" style="display: none;">

                                <?php
                                foreach($pc->getChildrenCategories() as $key => $childProductCategory) {
                                    ?>
                                    <div>
                                        <a href="<?php echo getProductCategoriesUri() . $childProductCategory->getFriendlyTitle();?>" class="sub-menu-link-inner<?php if (!is_null($productCategory) && $productCategory->getID() == $childProductCategory->getID()) { ?> active<?php } ?>">
                                            <span><?php echo $childProductCategory->getLocalizedTitle();?></span>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            </ul>
        </div>
</nav>