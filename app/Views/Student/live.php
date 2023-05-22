<section class="contenter">
    <div class="layer_top"></div>
    <div class="">
        <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
        <div id="player"></div>
    </div>
    <div class="layer_bottom"></div>
</section>
<section class="viewChatMessage" id="viewChatMessage">
    <div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div>
    <div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div>
    <div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div>
    <div class="myMsg">Message will be here<br><span class="showName">(Name)</span></div>
    <div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div><div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div><div class="otherMsg">Message will be here<br><span class="showName">(Name)</span></div>
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
        height: 40px;
        width: 75%;
    }
    .chatSendBtn{
        padding: 13px 0px;
        width: 22%;
    }
    .viewChatMessage{
        height: 300px;
        overflow: scroll;
    }
    .otherMsg{
        background: #ccc;
        padding: 10px;
        /* border-bottom: 1px solid #ccc; */
        /*width: 90%;*/
    }
    .myMsg{
        text-align: right;
        padding: 10px;
        background: #3aa357;
        /*width: 90%;*/
    }
    .showName{
        font-size: 12px;
    }
</style>
<script>

    // Chat option Script (Start)
    // This is for accessing web socket
    var conn = new WebSocket('ws://localhost:8081');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        //console.log(e.data);
        otherMessage(e.data);
    };

    // When send a message
    $("#send").on('click', function(){
        var msg = $("#chattext").val();
        if (msg.trim() == ''){
            return false;
        }
        conn.send(msg);
        myMessage(msg);
        $("#chattext").val('');
    });

    function myMessage(msg){
        var html = '<div class="myMsg">'+ msg +'<br><span class="showName">(Name)</span></div>';
        $(".viewChatMessage").append(html);
        scrollToBottom();
    }

    function otherMessage(msg){
        var html = '<div class="otherMsg">'+ msg +'<br><span class="showName">(Name)</span></div>';
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




