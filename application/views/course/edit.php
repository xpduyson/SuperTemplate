<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css");?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css");?>">
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
                <form method="post" action="<?php echo site_url('course/editCourse'); ?>">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>ID Course:</label>
                            <?php
                            $id = $this->uri->segment(3);
                           echo " <input readonly class=\"form-control\" name=\"txtid\" value=\"$id\">";
                           // echo "<p name=\"txtid\" value=\"$id\" id=\"txtid\">$id</p>";
                            ?>

                        </div>
                        <div class="form-group">
                            <label>Faculty:</label>
                            <select name="fac" id="fac" class="form-control">
                                <?php
                                $id = $this->uri->segment(3);
                                $cou = $this->db->where("couid",$id)->get('course')->row();
                                $faculties = $this->db->get('faculties');
                                foreach ($faculties->result() as $row)
                                {
                                    if($cou->faculty==$row->facid){
                                        echo "<option disabled selected value='$row->facdetails'>$row->facname|$row->facdetails</option>";
                                   }else{
                                        echo "<option disabled value='$row->facdetails'>$row->facname|$row->facdetails</option>";
                                    }

                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Course Title:</label>
                            <?php
                            $id = $this->uri->segment(3);
                            $cou = $this->db->where("couid",$id)->get('course')->row();
                            echo "<input required  class=\"form-control\" id=\"txtinputtitle\" name=\"txtinputtitle\" value=\"$cou->coutitle\">";

                            ?>

                        </div>
                          <div class="form-group">
                            <label>Time:</label>
                            <?php
                            $time=0;
                            $id = $this->uri->segment(3);
                            $faculty = $this->db->where("couid",$id)->get('course')->row()->faculty;
                            $status = $this->db->where("couid",$id)->get('course')->row()->status;
                            $result = $this->db->where("faculty",$faculty)->get('course');
                            $id = $this->uri->segment(3);
                            $cou = $this->db->where("couid",$id)->get('course')->row();
                            if($result->num_rows() > 0)
                            {
                                foreach($result->result() as $row)
                                {
                                    if($row->status==1){
                                        $time += $row->coutime;
                                    }
                                }

                                if($status==1){
                                    $a=$time-$cou->coutime;
                                    $max=12-$a;
                                }else{
                                    $a=$time;
                                    $max=12-$a;
                                }
                            }

                            echo "<input required name=\"txttime\" type=\"number\" min='0' max='$max' class=\"form-control\" value=\"$cou->coutime\">( Max:$max)";

                            ?>
                        </div>
                        <div class="form-group">
                            <label>Level:</label>
                            <select name="level" class="form-control">
                                <?php
                                $id = $this->uri->segment(3);
                                $cou = $this->db->where("couid",$id)->get('course')->row();
                                if($cou->coulevel==1){
                                    echo "<option selected value='1'>1</option>";
                                }else
                                {
                                    echo "<option value='1'>1</option>";
                                }

                                if($cou->coulevel==2){
                                    echo "<option selected value='2'>2</option>";
                                }else
                                {
                                    echo "<option value='2'>2</option>";
                                }
                                if($cou->coulevel==3){
                                    echo "<option selected value='3'>3</option>";
                                }else
                                {
                                    echo "<option value='3'>3</option>";
                                }
                                if($cou->coulevel==1){
                                    echo "<option selected value='4'>4</option>";
                                }else
                                {
                                    echo "<option value='4'>4</option>";
                                }
                                if($cou->coulevel==5){
                                    echo "<option selected value='5'>5</option>";
                                }else
                                {
                                    echo "<option value='5'>5</option>";
                                }
                                if($cou->coulevel==6){
                                    echo "<option selected value='6'>6</option>";
                                }else
                                {
                                    echo "<option value='6'>6</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Credit:</label>
                            <?php
                            $id = $this->uri->segment(3);
                            $cou = $this->db->where("couid",$id)->get('course')->row()->coucredit;
                            echo "<input required class=\"form-control\" step=\"5\" max=\"100\" min=\"0\" value='$cou' type=\"number\" name=\"txtcredit\">";
                            ?>

                        </div>


                        <div class="form-group">
                            <label>CL:</label>
                            <select name="cl" id="cl" class="form-control">


                                <?php
                                $id = $this->uri->segment(3);
                                $idStatus = $this->db->where("courses",$id)->get('cmr')->row()->c_m_r_status;
                                $idStatusChecked = $this->db->where("id",$idStatus)->get('cmr_status')->row()->cm_checked;


                                $idstaffSelect = $this->db->where("courses",$id)->get('coursestaff')->row()->users;
                                $userSelect = $this->db->where("id",$idstaffSelect)->get('users')->row()->username;

                                $users_groups = $this->db->where("group_id",4)->get('users_groups');
                                foreach ($users_groups->result() as $row)
                                {
                                    $users = $this->db->where("id",$row->user_id)->get('users')->row();
                                   // $usersid = $this->db->where("id",$users->id)->get('users')->row()->id;
                                    $idstaffSelect = $this->db->where("users",$users->id)->get('coursestaff')->row();
                                    if($idstaffSelect->courses==$id){
                                        echo "<option selected value='$users->username'>$users->username</option>";
                                    }else{
                                        echo "<option value='$users->username'>$users->username</option>";
                                    }


                                }

                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>CM:</label>
                            <select name="cm" id="cm" class="form-control">
                                <?php
                                $id = $this->uri->segment(3);
                                $idStatus = $this->db->where("courses",$id)->get('cmr')->row()->c_m_r_status;
                                $idStatusChecked = $this->db->where("id",$idStatus)->get('cmr_status')->row()->cm_checked;


                                $idstaffSelect = $this->db->where("courses",$id)->get('coursestaff')->row()->users;
                                $userSelect = $this->db->where("id",$idstaffSelect)->get('users')->row()->username;

                                $users_groups = $this->db->where("group_id",5)->get('users_groups');
                                foreach ($users_groups->result() as $row)
                                {
                                    $users = $this->db->where("id",$row->user_id)->get('users')->row();
                                    // $usersid = $this->db->where("id",$users->id)->get('users')->row()->id;
                                    $idstaffSelect = $this->db->where("users",$users->id)->get('coursestaff')->row();
                                    if($idstaffSelect->courses==$id){
                                        echo "<option selected value='$users->username'>$users->username</option>";
                                    }else{
                                        echo "<option value='$users->username'>$users->username</option>";
                                    }


                                }

                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <label class="radio-inline">
                                <?php
                                $id = $this->uri->segment(3);
                                $cou = $this->db->where("couid",$id)->get('course');
                                foreach ($cou->result() as $row)
                                {
                                   if($row->status==1){
                                       echo "<input disabled type=\"radio\" name=\"rdactive\" id=\"optionsRadiosInline1\" value=\"1\" checked>Active";

                                   }else{
                                       echo "<input disabled type=\"radio\" name=\"rdactive\" id=\"optionsRadiosInline1\" value=\"1\" >Active";

                                   }

                                }


                                ?>

                            </label>
                            <label class="radio-inline">
                                <?php
                                $id = $this->uri->segment(3);
                                $cou = $this->db->where("couid",$id)->get('course');
                                foreach ($cou->result() as $row)
                                {
                                    if($row->status==0){
                                        echo " <input disabled type=\"radio\" name=\"rdinactive\" id=\"optionsRadiosInline2\" value=\"0\" checked>InActive";

                                    }else{
                                        echo " <input disabled type=\"radio\" name=\"rdinactive\" id=\"optionsRadiosInline2\" value=\"0\">InActive";

                                    }

                                }


                                ?>

                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-success">Submit Edit</button>
                <button  class="btn btn-info">Back</button>
            </div>
            </form>
        </div>

    </form>

</div>
</body>
</html>