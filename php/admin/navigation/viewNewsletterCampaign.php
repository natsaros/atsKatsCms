<?php
$campaignId = $_GET["id"];
$campaign = NewsletterHandler::getNewsletterCampaign($campaignId);
?>

<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group" style="margin-bottom: 50px;">
            <label class="control-label" for="code_input">Title</label>
            <div>
                <?php echo $campaign->getTitle();?>
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 50px;">
            <label class="control-label" for="code_input">Message</label>
            <div>
                <?php
                $message = preg_replace('/<a(.*)href="([^"]*)"(.*)>/','<a$1href="javascript:void(0);"$3>', $campaign->getMessage());
                echo $message;
                ?>
            </div>
        </div>
        <?php if (isNotEmpty($campaign->getLink())) { ?>
            <div class="form-group" style="margin-bottom: 50px;">
                <label class="control-label" for="code_input">Link</label>
                <div>
                    <?php echo $campaign->getLink();?>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 50px;">
                <label class="control-label" for="code_input">Button Text</label>
                <div>
                    <?php echo $campaign->getButtonText();?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group" style="margin-bottom: 50px;">
            <label class="control-label" for="code_input">Sending Date</label>
            <div>
                <?php echo $campaign->getSendingDate();?>
            </div>
        </div>
        <div class="text-right form-group">
            <a type="button" href="<?php echo getAdminRequestUri() . "newsletter" . addParamsToUrl(array('activeTab'), array('newsletterCampaigns')); ?>"
               class="btn btn-default">Back</a>
        </div>
    </div>
</div>