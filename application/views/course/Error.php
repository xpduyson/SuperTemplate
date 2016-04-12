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
                <form method="post" action="<?php echo site_url('course/AddPage'); ?>">

                       <p>Error! This Course is have already exist ID Or You Haven't in course</p>
                <div class="panel-footer">
                <button type="submit" class="btn btn-success">Back</button>

                 </div>
                 </form>
        </div>

        </form>

    </div>
</body>
</html>