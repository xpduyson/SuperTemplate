<!DOCTYPE html>
<html>
<head>
    <script language="javascript">
        $(document).ready(function() {
            <?php
            $cmrdata = $this->session->flashdata('cmrNotComment');
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
</head>
<body>


<div class="row">
    <div class="col-md-4">
        <?php echo modules::run('adminlte/widget/box_open', 'Shortcuts'); ?>
        <?php echo modules::run('adminlte/widget/app_btn', 'fa fa-user', 'Account', 'panel/account'); ?>
        <?php echo modules::run('adminlte/widget/app_btn', 'fa fa-sign-out', 'Logout', 'panel/logout'); ?>
        <?php echo modules::run('adminlte/widget/box_close'); ?>

        <div class="info-box bg-red">
            <span class="info-box-icon "><i class="glyphicon glyphicon-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Courses</span>
                <span class="info-box-number"><?php echo $CourseSize ?></span>

            </div>
        </div>
        <div class="info-box bg-blue">
            <span class="info-box-icon "><i class="glyphicon glyphicon-list-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Faculties</span>
                <span class="info-box-number"><?php echo $FacultySize ?></span>

            </div>
        </div>
        <div class="info-box bg-green">
            <span class="info-box-icon "><i class="glyphicon glyphicon-file"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Course Monitoring Report</span>
                <span class="info-box-number"><?php echo $CMRSize ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">CMR Need Comment <?php echo "<b>[".$CMRNeedCommentSize." Courses]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($CMRNeedComment == 0)
                    {
                        echo "There is no CMR Need Comment";
                    }else{?>
                        <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Academic Year</th>
                            <th>Date Approved</th>
                            <th>Time Left</th>
                        </tr>

                        <?php

                        foreach($CMRNeedComment as $item) {
                            $date = time();
                            $cmrtime = strtotime($item['date_approved']);
                            $diff = $cmrtime + 1209600;
                            $goal = $diff - $date;
                            if($goal > 0)
                            {
                                $days=floor($goal/(60*60*24));
                                $hours=round(($goal-$days*60*60*24)/(60*60));
                                $timeleft = $days ." days ". $hours ." hours remain";
                            }else{
                                $timeleft = "Time's up";
                            }

                            echo "<tr>";
                            echo "<td>";
                            echo "<p>" . $item['cmrid'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['coutitle'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['facname'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['academic_year'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['date_approved'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $timeleft . "</p>";
                            echo "</td>";
                            echo "<tr>";
                        }
                    } ?>
                    </tr>
                </table>

            </div>
        </div>

</html>
