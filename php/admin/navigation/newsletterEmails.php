<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php
$newsletterEmails = NewsletterHandler::getAllNewsletterEmails();
$activeTab = $_GET['activeTab'];
$activeTabClass = 'class="active"';
?>

<ul class="nav nav-tabs">
    <li <?php if(isEmpty($activeTab) || $activeTab === 'newsletterEmails') {
        echo $activeTabClass ?><?php } ?>><a href="#newsletterEmails" data-toggle="tab">Newsletter Emails</a></li>
    <li <?php if(isNotEmpty($activeTab) && $activeTab === 'newsletterEmailForm') {
        echo $activeTabClass ?><?php } ?>><a href="#newsletterEmailForm" data-toggle="tab">Newsletter Email Form</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade <?php if(isEmpty($activeTab) || $activeTab === 'newsletterEmails') { ?> in active<?php } ?>" id="newsletterEmails">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover ak-dataTable">
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
                                    <td><?php echo $newsletterEmail->getDate(); ?></td>
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
    <div class="tab-pane fade <?php if(isEmpty($activeTab) || $activeTab === 'newsletterEmailForm') { ?> in active<?php } ?>" id="newsletterEmailForm">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
