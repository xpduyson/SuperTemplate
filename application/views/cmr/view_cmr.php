<!DOCTYPE html>
<html>
<head>
    <title>ADD CMR</title>
    <script>

        $(document).ready(function(){

            <?php
                if($this->ion_auth->in_group(array('DLT')))
                {
                    ?>if(document.getElementById('txtComment').value == '')
                    document.getElementById('txtComment').disabled = false;
            document.getElementById('btnApprove').style.visibility = 'hidden';
            <?php
            }
            ?>
            if(document.getElementById('txtComment').value != '')
                document.getElementById('btnSave').disabled = true;
            <?php
                 if($this->ion_auth->in_group(array('CL')))
                 {
                     ?> document.getElementById('btnSave').style.visibility = 'hidden';
            document.getElementById('btnApprove').style.visibility = 'hidden';<?php
                 }

            ?>
            <?php
            if($this->ion_auth->in_group(array('CM')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden';
            document.getElementById('btnApprove').style.visibility = 'visible';
            if(document.getElementById('isApprove').value == 1)
                document.getElementById('btnApprove').disabled = true;
            else
                document.getElementById('btnApprove').disabled = false;
            <?php

            }
            ?>
            <?php
            if($this->ion_auth->in_group(array('PVC')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden'
            document.getElementById('btnApprove').style.visibility = 'hidden';;<?php
            }

            ?>
            <?php
            if($this->ion_auth->in_group(array('admin')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden'
            document.getElementById('btnApprove').style.visibility = 'hidden';;<?php
            }

            ?>

        });
    </script>
<body>

    <div class="container">
        <form action="<?php echo site_url('cmr/addComment'); ?>" method="post">
        <div class="row">
            <!-- Create general CMR information form-->
            <table class="table">
                <thead>
                <tr>
                    <th class="bg-primary" style="text-align: center" colspan="2">COURSE MONITORING REPORT</th>
                </tr>
                </thead>
                <tbody>
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
                        <input hidden name="userID" value="<?php echo $cmrUser?>">
                    </td>

                </tr>
                </tbody>


            </table>
        </div>

        <!-- Create statistic data form-->
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th class="bg-primary" colspan="7">Statistical Data</th>
                </tr>
                </thead>
                <tbody>
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

                </tbody>
            </table>
        </div>
        <div class="row">
            <tr><strong>Comment</strong></tr>
        </div>

        <div class="row">
            <tr>
                <textarea disabled id="txtComment" rows="5" cols="100" name="comment"><?php echo $cmrStatus->dlt_comment ?></textarea>
            </tr>
        </div>
    <input hidden name="isApprove" value="<?php echo $cmrStatus->cm_checked ?>" id="isApprove"/>
        <div class="row"></div>
            <button name="submit" id="btnSave" type="submit"  class="btn btn-primary btn-lg pull-right"><span class="glyphicon glyphicon-save"> SAVE </span></button>
        </form>
            <button hidden name="approve" id="btnApprove" type="submit"  onclick="document.location.href='cmr/approveCmr'" class="btn btn-info btn-lg pull-right"><span class="glyphicon glyphicon-thumbs-up"> APPROVE </span></button>
            <button name="back" type="submit"  onclick="document.location.href='cmr'" class="btn btn-info btn-lg pull-left"><span class="glyphicon glyphicon-menu-left"> BACK </span></button>
    </div>

</body>

</html>

