<!DOCTYPE html>
<html>
<head>

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
                <h3 class="box-title">Course Without CMR <?php echo "<b>[".$CourseOutCMRByCLSize." Courses]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($CourseOutCMRByCL == 0)
                    {
                        echo "There is no Course Without CMR";
                    }else{?>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Faculty</th>
                        <th>Academic Year</th>
                    </tr>
                    <tr>
                        <?php

                        foreach($CourseOutCMRByCL as $item) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<p>" . $item['couid'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['coutitle'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['facname'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['academicyear'] . "</p>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        } ?>
                    </tr>
                </table>

            </div>
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Rejected CMR <?php echo "<b>[".$CMRRejectSize." CMR]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($CMRReject == 0)
                    {
                        echo "There is no Rejected CMR";
                    }else{?>
                        <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Academic Year</th>
                            <th>Date Submitted</th>
                        </tr>

                        <?php
                        foreach($CMRReject as $item) {
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
                            echo "<p>" . $item['academicyear'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['date_submitted'] . "</p>";
                            echo "</td>";
                            echo "<tr>";
                        }
                    } ?>

                </table>
            </div>
        </div>
</html>
