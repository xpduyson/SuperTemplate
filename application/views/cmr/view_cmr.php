<!DOCTYPE html>
<html>
<head>
    <title>ADD CMR</title>
    <script>

        $(document).ready(function () {

            <?php
                if($this->ion_auth->in_group(array('DLT')))
                {
            ?>
            var left = <?php echo $timeLeft ?>;
            if(left > 0){
                if ($("#txtComment").val(""))
                    document.getElementById('txtComment').disabled = false;
            }else{
                document.getElementById('txtComment').disabled = true;
                document.getElementById('btnSave').disabled = true;
            }

            document.getElementById('btnApprove').style.visibility = 'hidden';
            document.getElementById('btnReject').style.visibility = 'hidden';
            <?php
            }
            ?>
            if (document.getElementById('txtComment').value != '')
                document.getElementById('btnSave').disabled = true;
            <?php
            if($this->ion_auth->in_group(array('CL')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden';
            document.getElementById('btnApprove').style.visibility = 'hidden';
            document.getElementById('btnReject').style.visibility = 'hidden';
            <?php
            }

            ?>
            <?php
            if($this->ion_auth->in_group(array('CM')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden';
            document.getElementById('btnApprove').style.visibility = 'visible';
            document.getElementById('btnReject').style.visibility = 'visible';
            if (document.getElementById('isApprove').value == 1 || document.getElementById('isReject').value == 1)
            {
                document.getElementById('btnApprove').disabled = true;
                document.getElementById('btnReject').disabled = true;
            }

            else
            {
                document.getElementById('btnApprove').disabled = false;
                document.getElementById('btnReject').disabled = false;
            }

            <?php

            }
            ?>
            <?php
            if($this->ion_auth->in_group(array('PVC')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden'
            document.getElementById('btnApprove').style.visibility = 'hidden';
            ;<?php
            }

            ?>
            <?php
            if($this->ion_auth->in_group(array('webmaster')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden'
            document.getElementById('btnApprove').style.visibility = 'hidden';
            ;<?php
            }
            ?>
            <?php
            if($this->ion_auth->in_group(array('guest')))
            {
            ?> document.getElementById('btnSave').style.visibility = 'hidden'
            document.getElementById('btnApprove').style.visibility = 'hidden';
            ;<?php
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
            </table>
        </div>
        <div class="row">
            <div class="col-md-4">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-2"><strong>Academic Year</strong></td>
                        <td class="col-md-2">
                            <?php echo $cmrInfo->academic_year ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2"><strong>Course</strong></td>
                        <td class="col-md-2">
                            <?php echo $cmrInfo->coutitle ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-md-2"><strong>Faculty</strong></td>
                        <td class="col-md-2">
                            <?php echo $courseFaculty; ?>
                        </td>

                    </tr>
                    <tr>
                        <td class="col-md-2"><strong>Time</strong></td>
                        <td class="col-md-2">
                            <?php echo $courseTime; ?> months

                        </td>

                    </tr>
                    <tr>
                        <td class="col-md-2"><strong>Level</strong></td>
                        <td class="col-md-2">
                            <?php echo $courseLevel; ?>

                        </td>

                    </tr>
                    <tr>
                        <td class="col-md-2"><strong>Credit</strong></td>
                        <td class="col-md-2">
                            <?php echo $courseCredit; ?>

                        </td>

                    </tr>
                    <tr>
                        <td class="col-md-2"><strong>Status</strong></td>
                        <td class="col-md-2">
                            <?php echo $courseStatus; ?>

                        </td>

                    </tr>
                    <tr id="approveDate">
                        <td class="col-md-2"
                        "><strong>Mark Expected</strong></td>
                        <td class="col-md-2" id="approveCM">
                            <?php echo $courseMark; ?> %
                        </td>
                    </tr>
                    <tr id="approveDate">
                        <td class="col-md-2"
                        "><strong>Approved Date</strong></td>

                        <td class="col-md-2" id="approveCM"><?php if ($cmrStatus->cm_checked == 1) {
                                echo $cmrStatus->date_approved;
                            } else {
                                if($cmrStatus->reject == 1){
                                    echo 'Rejected';
                                }else
                                echo 'Not Approved';
                            }
                            ?> </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-8">
                <table class="table">
                    <tr class="row">
                        <td class="col-md-4"><strong>Course Leader</strong></td>
                        <td class="col-md-2">
                            <?php echo $user->first_name; ?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-md-4"><strong>Course Moderator</strong></td>
                        <td class="col-md-2" id="approveCM">
                            <?php echo $courseCM; ?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-md-4"><strong>Pro-Vice Chancellor </strong></td>
                        <td class="col-md-2">
                            <?php echo $coursePVC; ?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-md-4"><strong>Director of Learning and Quality </strong></td>
                        <td class="col-md-2">
                            <?php echo $courseDLT; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="row">
            <tr><strong>Comment</strong></tr>
        </div>

        <div class="row">
            <tr>
                <textarea required disabled id="txtComment" rows="5" cols="100"
                          name="comment"><?php echo $cmrStatus->dlt_comment ?></textarea>
            </tr>
        </div>
        <input hidden name="isApprove" value="<?php echo $cmrStatus->cm_checked ?>" id="isApprove"/>
        <input hidden name="isReject" value="<?php echo $cmrStatus->reject ?>" id="isReject"/>
        <div class="row"></div>
        <button name="submit" id="btnSave" type="submit" class="btn btn-primary btn-lg pull-right"><span
                class="glyphicon glyphicon-comment"> COMMENT </span></button>
    </form>
    <button hidden name="approve" id="btnReject" type="submit" onclick="document.location.href='cmr/rejectCmr'"
            class="btn btn-warning btn-lg pull-right"><span class="glyphicon glyphicon-thumbs-down"> REJECT </span>
    </button>

    <button hidden name="approve" id="btnApprove" type="submit" onclick="document.location.href='cmr/approveCmr'"
            class="btn btn-info btn-lg pull-right"><span class="glyphicon glyphicon-thumbs-up"> APPROVE </span></button>
    <button name="back" type="submit" onclick="document.location.href='cmr'" class="btn btn-info btn-lg pull-left"><span
            class="glyphicon glyphicon-menu-left"> BACK </span></button>
</div>

</body>

</html>

