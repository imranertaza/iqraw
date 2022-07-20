

    <section class="content">
        <div class="row">
            <div class="col-12 ">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" style="display: none;">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home"><i class="fa-solid fa-arrow-left"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu1"><i class="fa-solid fa-arrow-left"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu2" ><i class="fa-solid fa-arrow-left"></i></a>
                    </li>
                </ul>
                <form id="signupForm"  method="post" action="<?php echo base_url();?>/SignUp/sign_up_action">
                    <div class="tab-content" style="padding: 0px 0px 35px 0px;">

                        <div class="tab-pane container  active" id="home" >
                            <div class="text-center position-relative ">
                                <span class="con-l-1st">পড় তোমার</span><br>
                                <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                            </div><br>
                            <span class="title-1">Register</span>
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                            <span id="message"></span>
                            <div class="input-group mb-3 mt-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name"  required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father Name" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                            </div>
                            <center><img src="<?php echo base_url() ?>/assets/image/line-a.svg" alt=""></center>
                            <center><a  class="btn" onclick="conformValidation1st()" >Next</a></center>


                        </div>

                        <div class="tab-pane container fade" id="menu1" >
                            <div class="text-center position-relative ">
                                <span class="con-l-1st">জিনি তোমাকে</span><br>
                                <span class="con-l-2nd">সৃষ্টি <span style="color: #000000;">করেছেন</span></span>
                            </div><br>
                            <span class="title-1">Register</span>
                            <span id="message2"></span>
                            <div class="input-group mb-3 mt-3">
                                <input type="text" class="form-control" name="school_name" id="school_name" placeholder="School Name" required>
                            </div>

                            <div class="input-group mb-3">
                                <select class="form-control" name="gender" id="gender" style="margin-right: 5px;" required>
                                    <option value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <select class="form-control" name="religion" id="religion" style="margin-left: 5px;" required>
                                    <option value="">Religion</option>
                                    <option value="islam">Islam</option>
                                    <option value="hindu">Hindu</option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="age" id="age" placeholder="Age" >
                            </div>
                            <center><img src="<?php echo base_url() ?>/assets/image/line-b.svg" alt=""></center>
                            <center><a class="btn " onclick="conformValidation2st()">Next</a></center>
                        </div>

                        <div class="tab-pane container fade" id="menu2" >
                            <span id="message3"></span>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" >
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
                            </div>
                            <div class="input-group mb-3">
                                <select class="form-control" name="class_id" id="class_id" required>
                                    <option>Please select</option>
                                    <?php echo getListInOption('', 'class_id', 'name', 'class');?>
                                </select>
                            </div>
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs card-header-tabs sc-sel" role="group" aria-label="Basic radio toggle button group" data-bs-tabs="tabs">
                                <li class="nav-item">
                                    <input type="radio" class="btn-check" name="institute" id="btnr1" autocomplete="off" value="Madrasha" >
                                    <a class="nav-link " aria-current="true" data-bs-toggle="tab" onclick="checkInst()" href="#dhcp">Madrasah</a>
                                </li>
                                <li class="nav-item">
                                    <input type="radio" class="btn-check" name="institute" id="btnr2" autocomplete="off" value="School" >
                                    <a class="nav-link" data-bs-toggle="tab" onclick="checkInst2()" href="#static">School</a>
                                </li>
                            </ul>
                            <!-- Tabs navs -->

                            <!-- Tabs content -->
                            <div class="tab-content mt-4 mb-4">
                                <div class="tab-pane " id="dhcp">
                                    <div class="btn-group sel-redio" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="class_group" id="btnradio1" autocomplete="off" value="science" >
                                        <label class="btn btn-outline-success" for="btnradio1">Science</label>

                                        <input type="radio" class="btn-check" name="class_group" id="btnradio2" autocomplete="off" value="commerce">
                                        <label class="btn btn-outline-success" for="btnradio2">Commerce</label>

                                        <input type="radio" class="btn-check" name="class_group" id="btnradio3" autocomplete="off" value="arts">
                                        <label class="btn btn-outline-success" for="btnradio3">Arts</label>
                                    </div>
                                </div>


                                <div class="tab-pane" id="static">
                                    <div class="btn-group sel-redio" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="class_group" id="btnradio4" autocomplete="off" value="science" >
                                        <label class="btn btn-outline-success" for="btnradio4">Science</label>

                                        <input type="radio" class="btn-check" name="class_group" id="btnradio5" autocomplete="off" value="commerce">
                                        <label class="btn btn-outline-success" for="btnradio5">Commerce</label>

                                        <input type="radio" class="btn-check" name="class_group" id="btnradio6" autocomplete="off" value="arts">
                                        <label class="btn btn-outline-success" for="btnradio6">Arts</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Tabs content -->


                            <center><img src="<?php echo base_url() ?>/assets/image/line-c.svg" alt=""></center>
                            <center><a class="btn btnSignIn" onclick="conformValidation3rd()">Done</a></center>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>

