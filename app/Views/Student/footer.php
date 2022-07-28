<!--    footer-->
<nav class="navbar navbar-expand-md navbar-dark fixed-bottom p-2 footer">
    <a class="navbar-brand" href="#"><img src="<?php base_url(); ?>/assets/image/icon-w.svg" alt=""></a>
    <a class="navbar-brand" href="#"><img src="<?php base_url(); ?>/assets/image/icon-shopping.svg" alt=""></a>
    <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Dashboard">
        <div class="h-icon-bg"><img src="<?php base_url(); ?>/assets/image/icon-home-alt.svg" alt=""
                                    style="margin-top: 11px;"></div>
    </a>
    <a class="navbar-brand" href="#"><img src="<?php base_url(); ?>/assets/image/icon-notification.svg" alt=""></a>
    <a class="navbar-brand" href="#"><img src="<?php base_url(); ?>/assets/image/icon-badge-rank.svg" alt=""></a>
</nav>

<script>
    function anscatculate(url) {
        var quizId = $("#quiz_id").val();
        var ans = $('input[name="btnradio"]:checked').val();
        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        } else {
            $.ajax({
                url: '<?php echo base_url('Student/VideoQuiz/sessionUpdate')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function join_exam(url){
        var agree = confirm("Are you sure you wish to joined?");
        if (agree)
            location.replace(url);
        else
        return false;
    }

    function quizanscatculate(url){
        var quizId = $("#quiz_question_id").val();
        var ans = $('input[name="btnradio"]:checked').val();
        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else{

            $.ajax({
                url: '<?php echo base_url('Student/Quiz/result')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function mcqanscatculate(url){
        var quizId = $("#skill_question_id").val();
        var ans = $('input[name="btnradio"]:checked').val();

        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else {

            $.ajax({
                url: '<?php echo base_url('Student/Skill_development/ans_quiz')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function vocanscatculate(url){
        var quizId = $("#voc_quiz_id").val();
        var ans = $('input[name="btnradio"]:checked').val();

        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else {
            $.ajax({
                url: '<?php echo base_url('Student/Vocabulary/ans_quiz')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }


</script>
</body>
</html>