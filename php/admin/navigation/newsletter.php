<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$newsletterEmails = NewsletterHandler::getAllNewsletterEmails();
$newsletterCampaigns = NewsletterHandler::getAllNewsletterCampaigns();
$activeTab = $_GET['activeTab'];
$activeTabClass = 'class="active"';

$afterFormSubmission = false;

if (isset($_SESSION['sendNewsletterForm']) && !empty($_SESSION['sendNewsletterForm'])) {
    $afterFormSubmission = true;
    $form_data = $_SESSION['sendNewsletterForm'];
    unset($_SESSION['sendNewsletterForm']);
}
?>

<ul class="nav nav-tabs">
    <li <?php if(isEmpty($activeTab) || $activeTab === 'newsletterEmails') {
        echo $activeTabClass ?><?php } ?>><a href="#newsletterEmails" data-toggle="tab">Newsletter Emails</a></li>
    <li <?php if(isNotEmpty($activeTab) && $activeTab === 'newsletterEmailForm') {
        echo $activeTabClass ?><?php } ?>><a href="#newsletterEmailForm" data-toggle="tab">Newsletter Email Form</a></li>
    <li <?php if(isNotEmpty($activeTab) && $activeTab === 'newsletterCampaigns') {
        echo $activeTabClass ?><?php } ?>><a href="#newsletterCampaigns" data-toggle="tab">Newsletter Campaigns</a></li>
</ul>

<div class="tab-content">
    <div class="fade<?php if(isEmpty($activeTab) || $activeTab === 'newsletterEmails') { ?> in active<?php } ?>" id="newsletterEmails">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover newsletterEmails-dataTable">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Subscription Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!is_null($newsletterEmails) && count($newsletterEmails) > 0) {
                            foreach ($newsletterEmails as $key => $newsletterEmail) {
                                $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                                ?>
                                <tr class="<?php echo $oddEvenClass ?>">
                                    <td><?php echo $newsletterEmail->getEmail(); ?></td>
                                    <td data-sort="<?php echo $newsletterEmail->getDate(); ?>"><?php echo date(ADMIN_DATE_FORMAT, strtotime($newsletterEmail->getDate())); ?></td>
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
    </div>
    <div class="fade<?php if ($activeTab === 'newsletterEmailForm') { ?> in active<?php } ?>" id="newsletterEmailForm">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <?php
                    $action = getAdminActionRequestUri() . "newsletter" . DS . "sendNewsletterEmail";
                    ?>
                    <form name="sendNewsletterForm" role="form" action="<?php echo $action?>" data-toggle="validator" method="post">
                        <input type="hidden" name="<?php echo NewsletterHandler::CURRENT_TAB ?>"  value="newsletterEmailForm"/>

                        <div class="form-group">
                            <label class="control-label" for="link_input">Title *</label>
                            <input class="form-control" placeholder="Title"
                                   name="<?php echo NewsletterHandler::TITLE ?>" id="link_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[NewsletterHandler::TITLE]?><?php } ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="message_input">Message *</label>
                            <textarea class="editor" name="<?php echo NewsletterHandler::MESSAGE ?>" id="message_input" required>
                            <?php if($afterFormSubmission) {?><?=$form_data[NewsletterHandler::MESSAGE]?><?php } ?>
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="link_input">Link</label>
                            <input class="form-control" placeholder="Link"
                                   name="<?php echo NewsletterHandler::LINK ?>" id="link_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[NewsletterHandler::LINK]?><?php } ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="buttonText_input">Button Text</label>
                            <input class="form-control" placeholder="Button Text"
                                   name="<?php echo NewsletterHandler::BUTTON_TEXT ?>" id="buttonText_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[NewsletterHandler::BUTTON_TEXT]?><?php } ?>"
                            >
                        </div>
                        <div class="text-right form-group">
                            <button type="submit" name="submit" class="btn btn-outline btn-primary">Send <span class="fa fa-envelope fa-fw" aria-hidden="true"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="fade<?php if ($activeTab === 'newsletterCampaigns') { ?> in active<?php } ?>" id="newsletterCampaigns">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover newsletterCampaigns-dataTable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Sending Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!is_null($newsletterCampaigns) && count($newsletterCampaigns) > 0) {
                            foreach ($newsletterCampaigns as $key => $newsletterCampaign) {
                                $oddEvenClass = $key % 2 == 0 ? 'odd' : 'even';
                                ?>
                                <tr class="<?php echo $oddEvenClass ?>">
                                    <td><?php echo $newsletterCampaign->getTitle(); ?></td>
                                    <td><?php echo $newsletterCampaign->getLink(); ?></td>
                                    <td data-sort="<?php echo $newsletterCampaign->getSendingDate(); ?>"><?php echo date(ADMIN_DATE_FORMAT, strtotime($newsletterCampaign->getSendingDate())); ?></td>
                                    <td>
                                        <a type="button"
                                           href="<?php echo getAdminRequestUri() . "viewNewsletterCampaign" . addParamsToUrl(array('id'), array($newsletterCampaign->getID())); ?>"
                                           class="btn btn-default btn-sm" title="Edit Product">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
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
    </div>
</div>
