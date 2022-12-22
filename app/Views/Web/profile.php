<section class="content-three con-mr">
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <p class="cor-title"> প্রোফাইল </p>
            </div>

            <div class="col-12 text-center" style="margin-bottom: 40px;">
                <?php $img = (!empty($student->pic))?$student->pic:'../noimage.png'; ?>
                <img src="<?php echo base_url() ?>/assets/upload/profile/<?php echo newSession()->std_id?>/<?php echo $img; ?>" alt="profile" title="Profile"
                     class="pro-img-up">
            </div>
            <div class="col-12 text-center" >
                <div class="message mt-2">
                    <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                </div>
            </div>
            <div class="col-12 text-center" style="margin-bottom: 100px;">
                <form action="<?php base_url() ?>/Web/Profile/update_action" method="post"
                      enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6">


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
                                       value="<?php echo $student->father_name; ?>" >
                            </div>

                            <div class="input-group mt-2">
                                <input type="text" class="form-control" placeholder="Address" name="address"
                                       value="<?php echo $student->address; ?>" >
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
                                       value="<?php echo $student->age; ?>" >
                            </div>


                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
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
                                <select class="form-control" name="class_id" id="class_id" >
                                    <option value="">Class</option>
                                    <?php echo getListInOption($student->class_id, 'class_id', 'name', 'class'); ?>
                                </select>
                            </div>

                            <div class="input-group mt-2">
                                <select class="form-control" name="class_group_id" id="class_group_id">
                                    <option value="">Class Group</option>
                                    <?php echo getListInOption($student->class_group_id, 'class_group_id', 'group_name', 'class_group'); ?>
                                </select>
                            </div>

                            <div class="input-group mt-2">
                                <input type="file" class="form-control" name="pic" placeholder="pic">
                            </div>

                            <div class="input-group mt-4">
                                <button class="btn bnt-up-profile">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>