<section class="content-one con-mr">
    <div class="container">
        <div class="row ">
            <?php if (!empty($description)) { ?>
                <div class="col-md-6 col-sm-12 col-lg-6 ">
                    <p class="dte-main-title"><?php echo $description->title; ?></p>
                    <p class="dte-main-text"><?php echo $description->short_description; ?></p>

                    <p class="dte-con-title mt-5">ফুল সিলেবাস কোর্সে যা যা থাকছে</p>
                    <div class="row custom-selabas">
                        <div class="col-md-12  ">
                            <div class="border rounded pt-2 pb-5 m-0 h-100">
                                <?php echo $description->syllabus; ?>
                            </div>
                        </div>
                    </div>

                    <p class="dte-con-title mt-5">কোর্স সম্পর্কে বিস্তারিত</p>
                    <div class="row border rounded p-3 m-0 con-css-cust">
                        <div class="col-md-12">
                            <p class="dte-con-title-sub">কোর্সটি কাদের জন্য?</p>
                            <?php echo $description->for_who; ?>

                            <hr class="hr-del my-5">

                            <p class="dte-con-title-sub">কোর্সটি কেন প্রয়োজন?</p>
                            <?php echo $description->for_why; ?>

                            <hr class="hr-del my-5">

                            <p class="dte-con-title-sub">কোর্সে যা যা থাকছে:</p>

                            <?php echo $description->what_is_included; ?>
                        </div>
                    </div>

                    <p class="dte-con-title mt-5">প্রায়শ জিজ্ঞাসিত প্রশ্নাবলী</p>
                    <div class="row ">
                        <div class="col-md-12  con-css-cust">
                            <div class="border rounded p-4 m-0 h-100">
                                <?php echo $description->faq; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <iframe class="video-det" width="100%" height="350" src="<?php echo $description->video; ?>"
                            title="How to Make a Shock Absorption System for Skateboards" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>

                    <button class="btn w-100 btn-det mt-3 " data-bs-toggle="modal" data-bs-target="#enrolModal">Enrol
                        Now
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="enrolModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bor-red">
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url('Web/Class_detail/package_subscribe')?>" method="post">
                                    <p class="mod-title-det m-0">সুবিধামত ফি পরিশোধ করুন</p>
                                    <p class="mod-text-det">লাইভ ক্লাস, পরীক্ষা– সব নিয়ে বছরব্যাপী পড়াশোনার আয়োজন</p>

                                    <div class="mt-4">
                                        <?php $i=1;$j=1; foreach ($package as $key => $val){ ?>
                                        <div class="form-check box mt-3">
                                            <input class="form-check-input" type="radio" name="class_subscription_package_id"
                                                   id="exampleRadios_<?php echo $i++;?>" value="<?php echo $val->class_subscription_package_id;?>" <?php echo ($key == 0)?'checked':'';?> >
                                            <label class="form-check-label d-flex justify-content-between"
                                                   for="exampleRadios_<?php echo $j++;?>">
                                                <div class="text-1">
                                                    <p class="m-0 text-1-t"><?php echo $val->name;?></p>
                                                    <p class="m-0 text-1-t-2"><?php echo $val->short_description;?></p>
                                                </div>
                                                <div class="text-2">
                                                    <p><?php echo $val->m_fee;?>৳</p>
                                                </div>
                                            </label>
                                        </div>
                                        <?php } ?>


                                    </div>

                                    <center>
                                        <button type="submit" class="btn mt-3 btn-agiea">এগিয়ে যান</button>
                                    </center>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php } else { ?>
                <div class="col-12 text-center">
                    <p class="dte-main-title">Upcoming content details</p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>