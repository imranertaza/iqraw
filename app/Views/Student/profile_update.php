<section class="extra-head">
    <div class="row pt-2">
        <div class="col-12">
            <div class="message mt-2">
                <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="content" style="margin-bottom: 90px; ">
    <form action="<?php echo base_url() ?>/Mobile_app/Profile/update_action" method="post">
        <div class="row pt-2">
            <div class="col-12">
                <div class="input-group mt-2">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="<?php echo $student->name; ?>" required>
                </div>

                <div class="input-group mt-2">
                    <input type="number" class="form-control" placeholder="Phone" name="phone"
                           value="<?php echo $student->phone; ?>" required>
                </div>

                <div class="input-group mt-2">
                    <input type="text" class="form-control" placeholder="Father Name" name="father_name"
                           value="<?php echo $student->father_name; ?>">
                </div>

                <div class="input-group mt-2">
                    <input type="text" class="form-control" placeholder="Address" name="address"
                           value="<?php echo $student->address; ?>">
                </div>

                <div class="input-group mt-2">
                    <select class="form-control" name="gender" id="gender" required>
                        <option value="">Gender</option>
                        <option value="Male" <?php echo ($student->gender == 'Male') ? 'selected' : ''; ?> >
                            Male
                        </option>
                        <option value="Female" <?php echo ($student->gender == 'Female') ? 'selected' : ''; ?>>
                            Female
                        </option>
                        <option value="Unisex" <?php echo ($student->gender == 'Unisex') ? 'selected' : ''; ?>>
                            Unisex
                        </option>
                    </select>
                </div>

                <div class="input-group mt-2">
                    <input type="text" class="form-control" placeholder="age" name="age"
                           value="<?php echo $student->age; ?>">
                </div>
                <div class="input-group mt-2">
                    <select class="form-control" name="religion" id="religion" required>
                        <option value="">Religion</option>
                        <option value="Islam" <?php echo ($student->religion == 'Islam') ? 'selected' : ''; ?>>
                            Islam
                        </option>
                        <option value="Hindu" <?php echo ($student->religion == 'Hindu') ? 'selected' : ''; ?>>
                            Hindu
                        </option>
                        <option value="Christian" <?php echo ($student->religion == 'Christian') ? 'selected' : ''; ?>>
                            Christian
                        </option>
                        <option value="Buddhism" <?php echo ($student->religion == 'Buddhism') ? 'selected' : ''; ?>>
                            Buddhism
                        </option>
                    </select>
                </div>
                <div class="input-group mt-2">
                    <select class="form-control" name="institute" id="institute" required>
                        <option value="">Institute</option>
                        <option value="School" <?php echo ($student->institute == 'School') ? 'selected' : ''; ?> >
                            School
                        </option>
                        <option value="Madrasha" <?php echo ($student->institute == 'Madrasha') ? 'selected' : ''; ?> >
                            Madrasha
                        </option>
                    </select>
                </div>

                <div class="input-group mt-2">
                    <input type="text" class="form-control" placeholder="School Name" name="school_name"
                           value="<?php echo $student->school_name; ?>">
                </div>

                <div class="input-group mt-2">
                    <select class="form-control" name="class_id" id="class_id" onchange="groupCheck(this.value)"  >
                        <option value="">Class</option>
                        <?php echo getListInOption($student->class_id, 'class_id', 'name', 'class'); ?>
                    </select>
                </div>

                <div class="input-group mt-2">
                    <select class="form-control" name="class_group_id" id="class_group_id">
                        <option value="">Class Group</option>
                        <?php echo getClassIdByGroupListInOption($student->class_group_id, $student->class_id); ?>
                    </select>
                </div>

                <div class="input-group mt-4">
                    <button class="btn btn-down">Update</button>
                </div>
            </div>
        </div>
    </form>

</section>