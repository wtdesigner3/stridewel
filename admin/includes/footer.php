    <!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/js-cookie/js.cookie.js"></script>
	<script src="assets/js/theme/default.min.js"></script>
	<script src="assets/js/apps.min.js"></script>
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="assets/js/demo/table-manage-responsive.demo.min.js"></script>
	
	    <script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                 $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
    </script> 
	
	
    <script type="text/javascript">
    $(document).ready(function() {
        if (typeof App !== 'undefined' && App.init) {
            try { App.init(); } catch(e) { console.warn('App.init:', e); }
        }
        if (typeof window.initAdminSelect2 === 'function') {
            window.initAdminSelect2();
        }
        $('#page-loader').fadeOut(200, function() { $(this).remove(); });
        $('#page-container').addClass('show in');

        <?php if(isset($_SESSION['success'])){ ?>
        if (typeof $.toast !== 'undefined') {
            $.toast({
                text: '<?php echo addslashes($_SESSION['success']); ?>',
                heading: 'Success',
                showHideTransition: 'slide',
                icon: 'success'
            });
        }
        <?php unset($_SESSION['success']); } ?>

        <?php if(isset($_SESSION['error'])) { ?>
        if (typeof $.toast !== 'undefined') {
            $.toast({
                text: '<?php echo addslashes($_SESSION['error']); ?>',
                heading: 'Ooh Snapp..',
                showHideTransition: 'slide',
                icon: 'error'
            });
        }
        <?php unset($_SESSION['error']); } ?>

        <?php if(isset($_SESSION['info'])) { ?>
        if (typeof $.toast !== 'undefined') {
            $.toast({
                text: '<?php echo addslashes($_SESSION['info']); ?>',
                heading: 'Ooh Great..',
                showHideTransition: 'slide',
                icon: 'info'
            });
        }
        <?php unset($_SESSION['info']); } ?>

        <?php if(isset($_SESSION['warning'])){ ?>
        if (typeof $.toast !== 'undefined') {
            $.toast({
                text: '<?php echo addslashes($_SESSION['warning']); ?>',
                heading: 'Ooh..',
                showHideTransition: 'slide',
                icon: 'warning'
            });
        }
        <?php unset($_SESSION['warning']); } ?>

        <?php if(isset($_SESSION['status'])) { ?>
        if (typeof $.toast !== 'undefined') {
            $.toast({
                text: '<?php echo addslashes($_SESSION['status']); ?>',
                heading: 'Notice',
                showHideTransition: 'slide'
            });
        }
        <?php unset($_SESSION['status']); } ?>
    });

    $(window).on('load', function() {
        $('#page-loader').remove();
        $('#page-container').addClass('show in');
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>