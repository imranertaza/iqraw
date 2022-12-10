<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(0);
?>
<nav>
    <?php if ($pager->hasPrevious()) : ?>
<!--        <span class="f-ti-1"><a class="btn sub-btn" href="javascript:void(0)" > Submit </a></span>-->
    <?php endif ?>

    <?php if ($pager->hasNext()){?>
        <span class="f-ti-1" style="float: right;"><a href="javascript:void(0)"  onclick="mcqanscatculate('<?php echo $pager->getnext() ?? '#' ?>')" > Next <i class="fa-solid fa-arrow-right-long" style="margin-left: 7px;" ></i></a></span>
    <?php }else{?>
        <span class="f-ti-1"><a class="btn sub-btn" href="javascript:void(0)" onclick="mcqanscatculate('<?php echo base_url(); ?>/Mobile_app/Skill_development/result_view')"> Submit </a></span>
    <?php } ?>
</nav>
