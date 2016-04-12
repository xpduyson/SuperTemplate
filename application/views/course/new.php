<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
</head>
<body>
<div id="page-wrapper">
    <div class="col-lg-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                Set Course
            </div>
            <div class="panel-body">
                <form method="post" action="<?php echo site_url('course/addCourse'); ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>ID Course:</label>

                                <input required class="form-control" id="txtid" name="txtid" placeholder="ID Course">

                            </div>

                            <div class="form-group">
                                <label>Course Title:</label>

                                <input required class="form-control" id="txtinputtitle" name="txtinputtitle"
                                       placeholder="Course Title">
                            </div>
                            <div class="form-group">
                                <label>Time:</label>
                                <?php


                                echo "<input readonly name=\"txttime\" type=\"number\"  class=\"form-control\" value=\"0\">";

                                ?>
                            </div>
                            <div class="form-group">
                                <label>Level:</label>
                                <select name="level" class="form-control">
                                    <?php


                                    echo "<option selected value='1'>1</option>";
                                    echo "<option value='2'>2</option>";
                                    echo "<option value='3'>3</option>";
                                    echo "<option value='4'>4</option>";
                                    echo "<option value='5'>5</option>";
                                    echo "<option value='6'>6</option>";

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Credit:</label>
                                <?php

                                echo "<input required class=\"form-control\" step=\"5\" max=\"100\" min=\"0\" value='40' type=\"number\" name=\"txtcredit\">";
                                ?>

                            </div>


                            <div class="form-group">
                                <label>CL:</label>
                                <select name="cl" id="cl" class="form-control">


                                    <?php


                                    $users_groups = $this->db->where("group_id", 4)->get('users_groups');
                                    foreach ($users_groups->result() as $row) {
                                        $users = $this->db->where("id", $row->user_id)->get('users')->row();

                                        echo "<option value='$users->id'>$users->username</option>";


                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>CM:</label>
                                <select name="cm" id="cm" class="form-control">
                                    <?php

                                    $users_groups = $this->db->where("group_id", 5)->get('users_groups');
                                    foreach ($users_groups->result() as $row) {
                                        $users = $this->db->where("id", $row->user_id)->get('users')->row();
                                        echo "<option value='$users->id'>$users->username</option>";

                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <label class="radio-inline">


                                    <input type="radio" name="rdactive" id="optionsRadiosInline1" value="1" checked>Active


                                </label>
                                <label class="radio-inline">

                                    <input type="radio" name="rdactive" id="optionsRadiosInline2" value="0">InActive
                                </label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-success">Submit Add</button>

            </div>
            </form>
        </div>

        </form>

    </div>
</body>
</html>