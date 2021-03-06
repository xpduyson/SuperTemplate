<?php echo $form->messages(); ?>

<div class="row">

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">User Info</h3>
            </div>
            <div class="box-body">
                <?php echo $form->open(); ?>

                <?php echo $form->bs3_text('Username', 'username'); ?>
                <?php echo $form->bs3_text('First Name', 'first_name'); ?>
                <?php echo $form->bs3_text('Last Name', 'last_name'); ?>

                Faculty:
                <td class="col-md-10">
                    <select required name="faculty" id="faculties">
                        <?php
                        if (empty($faculties)) ?>
                            <option value="">Select Faculty</option>
                            <?php
                        foreach ($faculties as $value) {
                            ?>
                            <option value="<?php echo $value['facid']; ?>">
                                <?php echo $value['facname']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>

                <?php echo $form->bs3_password('Password', 'password'); ?>
                <?php echo $form->bs3_password('Retype Password', 'retype_password'); ?>

                <?php if (!empty($groups)): ?>
                    <div class="form-group">
                        <label for="groups">Groups</label>
                        <div>
                            <?php foreach ($groups as $group): ?>
                                <label class="checkbox-inline">
                                    <input type="radio" name="groups[]"
                                           value="<?php echo $group->id; ?>"> <?php echo $group->description; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $form->bs3_submit(); ?>

                <?php echo $form->close(); ?>
            </div>
        </div>
    </div>

</div>