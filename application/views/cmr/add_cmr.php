<!DOCTYPE html>
<html>
<head>
    <title>ADD CMR</title>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css");?>">
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
</head>

<body>
<div class="container">
    <form method="post" action="<?php echo site_url('cmr/addCmr'); ?>">
        <div class="row">
            <!-- Create general CMR information form-->
            <table class="table">
                <thead>
                <tr>
                    <th class="bg-primary" style="text-align: center" colspan="2">COURSE MONITORING REPORT</th>
                </tr>
                <tr >
                    <td class="col-md-2" id="addon1"><strong>Academic Year</strong></td>
                    <td class="col-md-10">
                        <select required name="acaYear" id="acaYear">
                            <?php
                            if(empty($selectedCmrID))?>
                                <option  value="">Select Academic Year</option>
                                <?php
                            {
                                foreach ($cmrYear as $cmrData)
                                {
                                    ?> <option name="acayear" value="<?php echo $cmrData['year'];?>">
                                    <?php echo $cmrData['year'];?></option>
                                    <?php
                                }
                            }?>

                        </select>
                    </td>
                </tr>
                <tr >
                    <td class="col-md-2"  id="addon2"><strong>Course</strong></td>

                    <td class="col-md-10">
                        <select required name="couID" id="selectCou">
                            <?php
                            if(empty($selectedCmrID))?>
                                <option value="">Select Course</option>
                                <?php
                            {
                                foreach ($cmrCourses as $courseData)
                                {
                                    ?> <option value="<?php echo $courseData['couid'];?>">
                                    <?php echo $courseData['coutitle'];?></option>
                                    <?php
                                }
                            }?>


                        </select>
                    </td>
                </tr>
                <tr >
                    <td class="col-md-2"  id="addon3"><strong>Course Leader</strong></td>
                    <td class="col-md-10">
                         <?php echo $user->first_name; ?>
                        <input hidden name="userID" value="<?php echo $user->id;?>">
                    </td>

                </tr>
                </thead>
            </table>
        </div>

        <!-- Create statistic data form-->
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th class="bg-primary" colspan="7">Statistical Data</th>
                </tr>
                <tr>
                    <th></th>
                    <th>CW1</th>
                    <th>CW2</th>
                    <th>CW3</th>
                    <th>CW4</th>
                    <th>EXAM</th>
                    <th>OVERALL</th>
                </tr>
                <tr>
                    <td><strong>Mean</strong></td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[0][mean]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[1][mean]"> </td>
                    <td><input required required size="3" min="1" max="100" type="number" name="details[2][mean]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[3][mean]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[4][mean]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[5][mean]"> </td>
                </tr>
                <tr>
                    <td ><strong>Median</strong></td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[0][median]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[1][median]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[2][median]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[3][median]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[4][median]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[5][median]"> </td>
                </tr>
                <tr>
                    <td><strong>Standard Deviation</strong></td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[0][standarddeviation]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[1][standarddeviation]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[2][standarddeviation]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[3][standarddeviation]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[4][standarddeviation]"> </td>
                    <td><input required size="3" min="1" max="100" type="number" name="details[5][standarddeviation]"> </td>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row">
            <button name="submit" type="submit" class="btn btn-primary btn-lg pull-right" id="btnSaveCMR"><span class="glyphicon glyphicon-save"> SAVE</span></button>
        </div>
    </form>


</div>
</body>
</html>
