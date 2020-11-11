<?php
session_start();
if (isset($_SESSION["id"]) && isset($_SESSION["email"])) {
    $id = $_SESSION["id"];
    $email = $_SESSION["email"];
    //echo $email;
?>
    <html>
    <?php include("header.php"); ?>

    <body>
        <div class="row border-bottom">
            <div class="col-12">
                <section class="navbar custom-navbar navbar-fixed-top col-12 bg-dark pb-1" role="navigation">
                    <div class="row align-items-center col-12">
                        <div class="col-3 text-left">
                            <img src="/assets/img/LG.png" width="100px">
                        </div>
                        <div class="col-9 h4 text-center">
                            Tên cuộc trò chuyện
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row main_chat">
            <div class="col-3 border-right">
                <div class="list_user">
                    <div class="d-inline-block align-middle mr-2">
                        <img src="/assets/img/male.png" width="60px" height="60px" class="rounded-circle">
                    </div>
                    <div class="d-inline-block align-middle">
                        <h4>{{Tên cuộc trò chuyện}}</h4>
                        <small>{{Tin nhắn cuối cùng}}</small>
                    </div>
                </div>
                <div class="list_user">
                    <div class="d-inline-block align-middle mr-2">
                        <img src="/assets/img/male.png" width="60px" height="60px" class="rounded-circle">
                    </div>
                    <div class="d-inline-block align-middle">
                        <h4>{{Tên cuộc trò chuyện}}</h4>
                        <small>{{Tin nhắn cuối cùng}}</small>
                    </div>
                </div>
            </div>
            <div class="col-9 frame_chat">
                <div class="message_list mt-3">
                    <div class="message row col-12 justify-content-start mt-2">
                        <div class="mr-2">
                            <img src="/assets/img/male.png" width="40px" height="40px" class="rounded-circle">
                        </div>
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-start mt-2">
                        <div class="mr-2">
                            <img src="/assets/img/male.png" width="40px" height="40px" class="rounded-circle">
                        </div>
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-start mt-2">
                        <div class="mr-2">
                            <img src="/assets/img/male.png" width="40px" height="40px" class="rounded-circle">
                        </div>
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-end mt-2">
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-end mt-2">
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-end mt-2">
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="message row col-12 justify-content-end mt-2">
                        <div class="message_outer">
                            <div class="message_content rounded">
                                <div class="message_text">
                                    {{text_here}}
                                </div>
                            </div>
                            <div class="text-right">
                                <small>
                                    {{time}}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input_chat row col-12 border-top">
                    <div class="col-9">
                        <form action="/moddle/chat.php" method="post" class="submit_form">
                            <input type="text" name="chat_" placeholder="Nội dung tin nhắn..." class="form-control input_s">
                        </form>
                    </div>
                    <div class="col-3 row align-items-center text-right justify-content-end">
                        <div class="attachment mr-4">
                            <img src="/assets/img/upload.svg" width="30px" height="30px" />
                        </div>
                        <div class="like">
                            <img src="/assets/img/like.svg" width="30px" height="30px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
    <style>
        .list_user {
            margin-left: 20px;
            margin-top: 20px;
        }

        .main_chat {
            min-height: calc(100% - 130px);
        }

        body {
            min-height: 100%;
        }

        .frame_chat {
            position: relative;
            min-height: 100%;
            overflow: auto;
        }

        .input_chat {
            position: absolute;
            bottom: 0px;
        }

        .submit_form .input_s {
            border: 0px !important;
        }

        .like {
            color: #ce3232;
        }

        .message_list {
            width: 100%;
            min-height: calc(100% - 110px);
        }

        .message_content {
            background: -webkit-linear-gradient(to right, #434343, #000000);
            background: linear-gradient(to right, #434343, #000000);
            padding: 10px;
        }

        .message_outer {
            color: #FFFFFF;
            margin-bottom: 5px;
        }
    </style>
<?php
} else {
    header("Location: /view/login.php");
}
