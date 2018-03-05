<!-- jQuery -->
<script src="<?php echo JS_URI ?>jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo JS_URI ?>bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo JS_URI ?>metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo JS_URI ?>raphael/raphael.min.js"></script>

<?php if(strpos(ADMIN_PAGE_ID, 'updatePost') !== false) {
    echo '<script src="' . JS_URI . 'tinymce/tinymce.min.js"></script>';
} ?>

<?php if(strpos(ADMIN_PAGE_ID, 'morris') !== false) {
//    || strpos(ADMIN_PAGE_ID, 'tables') !== false
    echo '<script src="' . JS_URI . 'morrisjs/morris.min.js"></script>';
    echo '<script src="' . JS_URI . 'morris-data.js"></script>';
} ?>

<?php if(strpos(ADMIN_PAGE_ID, 'flot') !== false) {
    echo '<!-- Flot Charts JavaScript -->';
    echo '<script src="' . JS_URI . 'flot/excanvas.min.js"></script>';
    echo '<script src="' . JS_URI . 'flot/jquery.flot.js"></script>';
    echo '<script src="' . JS_URI . 'flot/jquery.flot.pie.js"></script>';
    echo '<script src="' . JS_URI . 'flot/jquery.flot.resize.js"></script>';
    echo '<script src="' . JS_URI . 'flot/jquery.flot.time.js"></script>';
    echo '<script src="' . JS_URI . 'flot-tooltip/jquery.flot.tooltip.min.js"></script>';
    echo '<script src="' . JS_URI . 'flot-data.js"></script>';
} ?>

<!-- Morris Charts JavaScript -->
<script src="<?php echo JS_URI ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo JS_URI ?>datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo JS_URI ?>datatables-plugins/dataTables.select.min.js"></script>
<script src="<?php echo JS_URI ?>datatables-responsive/dataTables.responsive.js"></script>

<script src="<?php echo JS_URI ?>bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="<?php echo JS_URI ?>daypilot/daypilot-all.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo JS_URI ?>sb-admin-2.min.js"></script>
<script src="<?php echo JS_URI ?>adminCustom.js"></script>