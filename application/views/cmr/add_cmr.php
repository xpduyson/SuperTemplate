<!DOCTYPE html>
<html>
<head>
    <title>ADD CMR</title>
    <script language="javascript" src="/assets/js/jquery-2.2.3.min.js"></script>
    <script>
        function showUser(couid) {
                document.getElementById("info").style.visibility = 'visible';
                $.ajax({
                    url: "<?php echo base_url(); ?>" + "cmr/getInfo",
                    dataType: 'json',
                    type: "post",
                    data: {
                        course: couid
                    },
                    success: function (result) {
                        $('#FalInfo').text(result.faculty);
                        $('#CMInfo').text(result.CM);
                        $('#PVCInfo').text(result.PVC);
                        $('#DLTInfo').text(result.DLT);
                        $('#TimeInfo').text(result.courseTime + ' months');
                        $('#LevelInfo').text(result.courseLevel);
                        $('#StatusInfo').text(result.courseStatus);
                        $('#CreditInfo').text(result.courseCredit);
                        $('#YearInfo').text(result.courseYear);
                        $('#acaYear').val(result.courseYear);
                    }
                });

        }
    </script>
</head>

<body>
<div class="container">
    <form method="post" action="<?php echo site_url('cmr/addCmr'); ?>">
        <input name="acaYear" hidden id="acaYear"/>
        <div class="row">
            <!-- Create general CMR information form-->
            <table class="table">
                <thead>
                <tr>
                    <th class="bg-primary" style="text-align: center" colspan="2">COURSE MONITORING REPORT</th>
                </tr>

                <tr >
                    <td class="col-md-2"  id="addon2"><strong>Course</strong></td>

                    <td class="col-md-10">
                        <select required name="couID" onchange="showUser(this.value)" id="selectCou">
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
                    <td class="col-md-2" ><strong>Course Leader</strong></td>
                    <td class="col-md-10">
                         <?php echo $user->first_name; ?>
                        <input hidden name="userID" value="<?php echo $user->id;?>">
                    </td>
                </tr>
                <tr >
                    <td class="col-md-2"><strong>Mark Planning</strong></td>
                    <td class="col-md-10">
                       <input type="number" min="1" max="100" name="mark" id="mark">%
                    </td>
                </tr>

                </thead>
            </table>
        </div>
        <h4><b class="col-md-12 bg-danger" style="text-align: center;"><?php echo $this->session->flashdata('errorMsg'); ?></b></h4>
        <div id="info" class="jumbotron">
            <div class="container">
                <div class="page-header">
                    <h4 style="text-align: center;color: #00a157;"><b>GENERAL INFORMATION</b></h4>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                            <tr>
                                <td class="col-md-1"><strong>Faculty </strong></td>
                                <td class="col-md-2"><div id="FalInfo"></div></td>
                            </tr>
                            <tr>
                                <td class="col-md-1"><strong>Year </strong></td>
                                <td class="col-md-2"><div id="YearInfo"></div></td>
                            </tr>
                            <tr>
                                <td class="col-md-1"><strong>Time </strong></td>
                                <td class="col-md-2"><div id="TimeInfo"></div> </td>
                            </tr>
                            <tr>
                                <td class="col-md-1"><strong>Level </strong></td>
                                <td class="col-md-2"><div id="LevelInfo"></div></td>
                            </tr>
                            <tr>
                                <td class="col-md-1"><strong>Credit </strong></td>
                                <td class="col-md-2"><div id="CreditInfo"></div></td>
                            </tr>
                            <tr>
                                <td class="col-md-1"><strong>Status </strong></td>
                                <td class="col-md-2"><div id="StatusInfo"></div></td>
                            </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td class="col-md-3"><strong>Course Moderator </strong></td>
                                    <td class="col-md-3"><div id="CMInfo"></div></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><strong>Pro-Vice Chancellor </strong></td>
                                    <td class="col-md-3"><div id="PVCInfo"></div></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><strong>Director of Learning and Quality </strong></td>
                                    <td class="col-md-3"><div id="DLTInfo"></div></td>
                                </tr>
                            </table>

                        </div>
                    </div>

            </div>

        </div>


        <div class="row">
            <button name="submit" type="submit" class="btn btn-primary btn-lg pull-right" id="btnSaveCMR"><span class="glyphicon glyphicon-save"> SAVE</span></button>
        </div>
    </form>


</div>
</body>
</html>
