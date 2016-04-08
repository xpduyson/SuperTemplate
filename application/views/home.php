<script type="text/javascript">
    $(document).ready(function() {
        <?php
        $cmrdata = $this->session->flashdata('cmrNotComment');
        $cmrdate = array();
        $role = $this->ion_auth->in_group(array('DLT'));
        if($role == true)
        {
        if(!empty($cmrdata)){
        ?>
        alert('You have CMR need to be commented:\n\n<?php
            foreach ($cmrdata as $cmr) {
            ?>• <?php
            $date = time();
            $cmrtime = strtotime($cmr['date_approved']);
            $diff = $cmrtime + 1209600;
            $goal = $diff - $date;
            $days=floor($goal/(60*60*24));
            $hours=round(($goal-$days*60*60*24)/(60*60));
            echo $cmr['cmrid']. " - " .$cmr['coutitle'] . " - " .
                $days ." days ". $hours ." hours remain";?>\n<?php
            }}
        }
        ?>');

    });
</script>

<div class="row">

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/box_open', 'Shortcuts'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-user', 'Account', 'panel/account'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-sign-out', 'Logout', 'panel/logout'); ?>
		<?php echo modules::run('adminlte/widget/box_close'); ?>
	</div>

    TODO: SOME INFO ABOUT CMR
</div>

