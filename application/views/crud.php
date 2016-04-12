<?php if ( !empty($crud_note) ) echo "<p>$crud_note</p>"; ?>
<?php $message = $this->session->flashdata('message'); if ( !empty($message) ) echo "<p><h4 style='color: red;'>$message</h4></p>"; ?>
<?php if ( !empty($crud_output) ) echo $crud_output; ?>