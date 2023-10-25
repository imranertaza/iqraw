<section class="contenter">
    <div class="layer_top"></div>
    <div class="">
        <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
        <div id="player"></div>
    </div>
    <div class="layer_bottom"></div>
</section>
<section class="viewChatMessage" id="viewChatMessage">
    <?php $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" role="img" aria-labelledby="personIconTitle" stroke="#000000" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#000000"> <title id="personIconTitle">Person</title> <path d="M4,20 C4,17 8,17 10,15 C11,14 8,14 8,9 C8,5.667 9.333,4 12,4 C14.667,4 16,5.667 16,9 C16,14 13,14 14,15 C16,17 20,17 20,20"/> </svg>';
    foreach ($chats as $chat) {
        $styleClass = ($std_id == $chat->std_id) ? "myMsg" : "otherMsg";
        if ($chat->std_id == null){ $sender = "Admin"; ?>
            <div class="<?php print $styleClass; ?> d-flex justify-content-start "> <div style="padding: 0 10px;text-align: center; border-right: 1px solid #bfbfbf;" ><?php echo $iconSvg;?> <p><?php print $sender; ?></p> </div> <div style="margin-bottom: auto; margin-top: auto;padding-left: 10px;" ><span class="showName">(<?php print $chat->time; ?>)</span> <br><?php print $chat->text; ?></div></div>
        <?php }else {  $sender = ($std_id == $chat->std_id) ? "Me" : get_data_by_id('name', 'student', 'std_id', $chat->std_id);?>

            <div class="<?php print $styleClass; ?> d-flex justify-content-end"> <div style="margin-bottom: auto; margin-top: auto;padding-right: 10px;" ><span class="showName">(<?php print $chat->time; ?>)</span> <br><?php print $chat->text; ?> </div> <div style="text-align: center;padding: 0 10px;border-left: 1px solid #01782d;"> <?php echo $iconSvg;?> <p><?php print $sender; ?> </p></div></div>

        <?php } } ?>
</section>
<footer>
    <textarea class="chatarea" name="chattext" id="chattext"></textarea>
    <input type="submit" class="chatSendBtn" id="send" name="submit" value="Send">
</footer>

<style>
    body{
        padding: 0;
        margin: 0;
    }
    .contenter {
        position: relative;
        height:200px;
    }
    .layer_top {
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
        height: 25%;
    }
    .layer_bottom {
        position: absolute;
        left: 0;
        right: 0;
        top: 75%;
        width: 100%;
        height: 25%;
    }
    footer{
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
    }
    .chatarea{
        float: left;
        height: 55px;
        width: 75%;
        border-radius: 5px;
    }
    .chatSendBtn{
        padding: 13px 0px;
        width: 24%;
        border-radius: 5px;
    }
    .viewChatMessage{
        height: 300px;
        overflow: scroll;
        padding-top: 15px;
    }
    .otherMsg{
        background: #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 15px !important;
        width: 90%;
        float: left;
    }
    .myMsg{
        text-align: right;
        padding: 10px;
        background: #9dd7ad;
        margin-bottom: 10px;
        border-radius: 15px !important;
        width: 90%;
        float: right;
    }
    .showName{
        font-size: 12px;
    }
</style>
<script>

    // Chat option Script (Start)
    // This is for accessing web socket
    var conn = new WebSocket('ws://localhost:8081?live_id=<?php print $result->live_id; ?>&std_id=<?php print $std_id; ?>');
    conn.onopen = function(e) {
        console.log("Connection Established!");
        console.log(e);
        // otherMessage(e);
    };

    conn.onmessage = function(e) {
        //console.log(e);
        otherMessage(e.data);
    };

    // When send a message
    $("#send").on('click', function(){
        var msg = $("#chattext").val();
        if (msg.trim() == ''){
            return false;
        }
        // conn.send(JSON.stringify({command: "message", from:"9", to: "1", message: "Hello"}));
        conn.send(msg);
        myMessage(msg);
        $("#chattext").val('');
    });

    function myMessage(msg){
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes();
        var html = '<div class="myMsg">Me : '+ msg +'<br><span class="showName">('+ time +')</span></div>';
        $(".viewChatMessage").append(html);
        scrollToBottom();
    }

    function otherMessage(msg){
        var details = JSON.parse(msg);
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes();
        var html = '<div class="otherMsg">'+ details.sender +' : '+ details.message +'<br><span class="showName">('+ time +')</span></div>';
        $(".viewChatMessage").append(html);
        scrollToBottom();
    }

    // To Scroll bottom of the chat window
    var viewChatBox = document.querySelector('#viewChatMessage');
    function scrollToBottom() {
        viewChatBox.scrollTop = viewChatBox.scrollHeight;
    }
    // Chat option Script (End)



    // This is for Youtube API and script (Start)
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '200px',
            width: '100%',
            videoId: '<?php print $result->youtube_code; ?>',
            host: 'https://www.youtube-nocookie.com',
            playerVars: {
                'playsinline': 1,
                'autoplay': 1,
                'controls': 0,
                'disablekb': 1,
                'fs':0,
                'modestbranding':1,
            },
            // events: {
            //     'onReady': onPlayerReady,
            //     'onStateChange': onPlayerStateChange
            // }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.setVolume(100);
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            // setTimeout(stopVideo, 6000);
            stopVideo();
            done = true;
        }
    }
    function stopVideo() {
        player.stopVideo();
    }
    // This is for Youtube API and script (End)
</script>




