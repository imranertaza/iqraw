<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Live Class Manage</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Live Class</li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <h3 class="card-title">Manage Live Class</h3>

                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-block btn-danger" onclick="remove(<?php print $live_id; ?>)" title="Add"> <i class="fa fa-minus"></i> Close</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <section class="viewChatMessage" id="viewChatMessage">
                            <?php foreach ($chats as $chat) {
                            //$styleClass = ($chat->std_id == $std_id) ? "myMsg" : "otherMsg";
                            if ($chat->std_id == null){
                                $sender = "Admin";
                                $styleClass = "myMsg";
                                $sender = "Me";
                            }else {
                                $sender = get_data_by_id('name', 'student', 'std_id', $chat->std_id);
                                $styleClass = "otherMsg";
                            }
                            ?>
                                <div class="<?php print $styleClass; ?>"><?php print $sender; ?> : <?php print $chat->text; ?><br><span class="showName">(<?php print $chat->time; ?>)</span></div>
                            <?php } ?>
                        </section>
                        <div>
                            <textarea class="chatarea" name="chattext" id="chattext"></textarea>
                            <input type="submit" class="chatSendBtn" id="send" name="submit" value="Send">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


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
    var conn = new WebSocket('ws://localhost:8081?class_id=<?php print $live_id; ?>&std_id=');
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
        var html = '<div class="otherMsg">'+ details.sender +' : '+ details.message +'<br><span class="showName">('+time+')</span></div>';
        $(".viewChatMessage").append(html);
        scrollToBottom();
    }

    // To Scroll bottom of the chat window
    var viewChatBox = document.querySelector('#viewChatMessage');
    function scrollToBottom() {
        viewChatBox.scrollTop = viewChatBox.scrollHeight;
    }
    // Chat option Script (End)




    $(function () {
        $('#data_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                "url": '<?php echo base_url($controller.'/getAll') ?>',
                "type": "POST",
                "dataType": "json",
                async: "true"
            }
        });
    });

    function add() {
        // reset the form
        $("#add-form")[0].reset();
        $(".form-control").removeClass('is-invalid').removeClass('is-valid');
        $('#add-modal').modal('show');
        // submit the add from
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorElement: 'div ',
            errorClass: 'invalid-feedback',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if ($(element).is('.select')) {
                    element.next().after(error);
                } else if (element.hasClass('select2')) {
                    //error.insertAfter(element);
                    error.insertAfter(element.next());
                } else if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.next());
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {

                var form = $('#add-form');
                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: '<?php echo base_url($controller.'/add') ?>',
                    type: 'post',
                    data: form.serialize(), // /converting the form data into array and sending it to server
                    dataType: 'json',
                    beforeSend: function() {
                        $('#add-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {

                        if (response.success === true) {

                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                                $('#add-modal').modal('hide');
                            })

                        } else {

                            if (response.messages instanceof Object) {
                                $.each(response.messages, function(index, value) {
                                    var id = $("#" + index);

                                    id.closest('.form-control')
                                        .removeClass('is-invalid')
                                        .removeClass('is-valid')
                                        .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

                                    id.after(value);

                                });
                            } else {
                                Swal.fire({
                                    position: 'bottom-end',
                                    icon: 'error',
                                    title: response.messages,
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                            }
                        }
                        $('#add-form-btn').html('Add');
                    }
                });

                return false;
            }
        });
        $('#add-form').validate();
    }

    function remove(live_id) {
        Swal.fire({
            title: 'Are you sure of the deleting process?',
            text: "You cannot back after confirmation",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url($controller.'/remove') ?>',
                    type: 'post',
                    data: {
                        live_id: live_id
                    },
                    dataType: 'json',
                    success: function(response) {

                        if (response.success === true) {
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                            })
                            var currentURI = window.location.pathname;
                            if (currentURI != '/Admin/Live_class/') {
                                location.replace("<?php print base_url(); ?>/Admin/Live_class/")
                            }
                        } else {
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 1500
                            })


                        }
                    }
                });
            }
        })
    }

    function group(class_id){
        $.ajax({
            url: '<?php echo base_url($controller . '/get_group') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (response){
                $("#class_group").html(response);
                $("#edit-form #class_group").html(response);
                $("#class_group_search").html(response);
            }
        });
    }
</script>