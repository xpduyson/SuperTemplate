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
                        <?php echo $cmrInfo->academic_year ?>
                    </td>
                </tr>
                <tr >
                    <td class="col-md-2"  id="addon2"><strong>Course</strong></td>

                    <td class="col-md-10">
                        <?php echo $cmrInfo->coutitle ?>
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
                    <td><input disabled value="<?php echo $cmrDetails['cw1']->mean ?>" required size="3" min="1" max="100" type="number" name="details[0][mean]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw2']->mean ?>" required size="3" min="1" max="100" type="number" name="details[1][mean]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw3']->mean ?>" required required size="3" min="1" max="100" type="number" name="details[2][mean]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw4']->mean ?>" required size="3" min="1" max="100" type="number" name="details[3][mean]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwexam']->mean ?>" required size="3" min="1" max="100" type="number" name="details[4][mean]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwoverall']->mean ?>" required size="3" min="1" max="100" type="number" name="details[5][mean]"> </td>
                </tr>
                <tr>
                    <td ><strong>Median</strong></td>
                    <td><input disabled value="<?php echo $cmrDetails['cw1']->median ?>" required size="3" min="1" max="100" type="number" name="details[0][median]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw2']->median ?>" required size="3" min="1" max="100" type="number" name="details[1][median]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw3']->median ?>" required size="3" min="1" max="100" type="number" name="details[2][median]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw4']->median ?>" required size="3" min="1" max="100" type="number" name="details[3][median]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwexam']->median ?>" required size="3" min="1" max="100" type="number" name="details[4][median]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwoverall']->median ?>" required size="3" min="1" max="100" type="number" name="details[5][median]"> </td>
                </tr>
                <tr>
                    <td><strong>Standard Deviation</strong></td>
                    <td><input disabled value="<?php echo $cmrDetails['cw1']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[0][standarddeviation]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw2']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[1][standarddeviation]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw3']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[2][standarddeviation]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cw4']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[3][standarddeviation]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwexam']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[4][standarddeviation]"> </td>
                    <td><input disabled value="<?php echo $cmrDetails['cwoverall']->standarddeviation ?>" required size="3" min="1" max="100" type="number" name="details[5][standarddeviation]"> </td>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row">
            <button name="back" type="submit" onclick="window.location = 'cmr';" class="btn btn-info btn-lg pull-right"><span class="glyphicon glyphicon-menu-left"> BACK </span></button>
        </div>
    </div>
</body>
</html>
