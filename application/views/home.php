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
                <h3 class="box-title">Course Leader <?php echo "<b>[".$CLSize." person]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($CL == 0)
                    {
                        echo "There is no Course Leader";
                    }else{?>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Faculty</th>
                        <th>Course</th>
                        <th>Academic Year</th>
                    </tr>
                    <tr>
                 <?php

                        foreach($CL as $item) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<p>" . $item['first_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['last_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['facname'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['coutitle'] . "</p>";
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
                <h3 class="box-title">Course Moderator <?php echo "<b>[".$CMSize." person]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($CM == 0)
                    {
                        echo "There is no Course Moderator";
                    }else{?>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Faculty</th>
                        <th>Course</th>
                        <th>Academic Year</th>
                    </tr>

                        <?php
                        foreach($CM as $item) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<p>" . $item['first_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['last_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['facname'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['coutitle'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['academicyear'] . "</p>";
                            echo "</td>";
                            echo "<tr>";
                        }
                        } ?>

                </table>
            </div>
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Pro-Vice Chancellor <?php echo "<b>[".$PVCSize." person]</b>" ?> </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($PVC == 0)
                    {
                        echo "There is no Pro-Vice Chancellor";
                    }else{?>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Faculty</th>
                        <th>Academic Year</th>
                    </tr>

                        <?php
                        foreach($PVC as $item) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<p>" . $item['first_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['last_name'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['facname'] . "</p>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>" . $item['academicyear'] . "</p>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        }
                        ?>

                </table>
            </div>
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Director of Learning and Quality <?php echo "<b>[".$DLTSize." person]</b>" ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <?php
                    if($DLT == 0)
                    {
                        echo "There is no Director of Learning and Quality";
                    }else{?>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Faculty</th>
                        <th>Academic Year</th>
                    </tr>
                        <?php
                            foreach($DLT as $item){
                                echo"<tr>";
                                echo "<td>";
                                echo "<p>".$item['first_name']."</p>";
                                echo "</td>";
                                echo "<td>";
                                echo "<p>".$item['last_name']."</p>";
                                echo "</td>";
                                echo "<td>";
                                echo "<p>".$item['facname']."</p>";
                                echo "</td>";
                                echo "<td>";
                                echo "<p>".$item['academicyear']."</p>";
                                echo "</td>";
                                echo"</tr>";
                            }
                        }
                        ?>
                </table>
            </div>
        </div>
        <div class="bg-info" style="text-align: center"><h4><strong>Exception Reports</strong></h4></div>
        <form>
        <div>
            <select required name="couID" onchange="showExceptionReport(this.value)" id="selectCou">
                <?php
                if(empty($selectedCmrID))?>
                    <option value="">Select Academic Year</option>
                    <?php
                {
                    foreach ($academicYear as $year)
                    {
                        ?> <option value="<?php echo $year['year'];?>">
                        <?php echo $year['year'];?></option>
                        <?php
                    }
                }?>
            </select>
        </div>
        </form>
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <td class="col-md-3">Course Without CMR</td>
                        <td class="col-md-3" id="rpCourseNotCMR"></td>
                    </tr>
                    <tr>
                        <td class="col-md-3">CMR Without Approved</td>
                        <td class="col-md-3" id="rpCMRNotApproved"></td>
                    </tr>
                    <tr>
                        <td class="col-md-3">CMR Without Comment</td>
                        <td class="col-md-3" id="rpCMRNotComment"></td>
                    </tr>
                </table>

             </div>

       </div>
    </div>
</div>
</body>
<script>
    function showExceptionReport(year) {
        $.ajax({
            url: "<?php echo base_url(); ?>" + "home/getReport",
            dataType: 'json',
            type: "post",
            data: {
                year: year
            },
            success: function (result) {
               $("#rpCourseNotCMR").text("" + result.courseOutCMRSize + " Course");
               $("#rpCMRNotComment").text("" + result.cmrOutCommentSize + " CMR");
               $("#rpCMRNotApproved").text("" + result.cmrOutApprovedSize + " CMR");
            }
        });

    }
</script>
</html>
