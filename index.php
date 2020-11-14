<?php
session_start();
if (isset($_SESSION["id"]) && isset($_SESSION["email"])) {
    include("_connect.php");
    include("moddle/functions.php");
    $id = $_SESSION["id"];
    $email = $_SESSION["email"];
    $account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_account WHERE id = $id"));

    //echo $email;
    $thread_id = "";
    if (isset($_GET["thread_id"])) {
        $thread_id = $_GET["thread_id"];
        if (is_numeric($thread_id)) {
            if (check_user_in_room($thread_id) == false) {
                header("Location: /");
                die;
            }
        } else {
            header("Location: /");
            die;
        }
    } else {
        if (isset($_SESSION["thread_id"])) {
            header("Location: /index.php?thread_id=" . $_SESSION["thread_id"]);
            die;
        }
    }
?>
    <html>
    <?php include("header.php"); ?>

    <body>
        <script>
            window.room_id = '<?php echo $thread_id; ?>';
            window.user_id = '<?php echo $id; ?>';
            window.auth_token = '<?php include("moddle/hash.php");
                                    echo encrypt($id . "-" . time()) ?>';
        </script>
        <div class="row border-bottom">
            <div class="col-12">
                <section class="navbar custom-navbar navbar-fixed-top col-12 bg-dark pb-1" role="navigation">
                    <div class="row align-items-center col-12">
                        <div class="col-3 text-left">
                            <img src="/assets/img/LG.png" width="100px">
                        </div>
                        <div class="col-9 h4 text-center" id="title_message"></div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row main_chat">
            <div class="col-3 border-right frame_list_user p-0">
                <div class="list_user">
                    <div class="loader bar">
                        <div></div>
                    </div>
                </div>
                <div class="user_setting border-top">
                    <div class="user_room">
                        <div class="d-inline-block align-middle mr-2">
                            <img src="<?php echo $account["avatar"] ?>" width="60px" height="60px" class="rounded-circle">
                        </div>
                        <div class="d-inline-block align-middle">
                            <h4><?php echo $account["first_name"] . " " . $account["last_name"] ?></h4>
                            <small><a href="/logout.php">Đăng xuất</a></small>
                        </div>
                    </div>
                    <div class="add_group" data-toggle="modal" data-target="#modal-form">
                        <img src="/assets/img/plus.svg" width="40px" height="40px">
                    </div>
                </div>
            </div>
            <div class="col-9 frame_chat">
                <div class="message_list mt-3">
                    <div class="center_text_absolute" id="no_message">
                        No messages here!
                    </div>
                </div>
                <div class="input_chat row col-12 border-top">
                    <div class="col-9">
                        <div class="submit_form">
                            <input type="text" name="chat_" placeholder="Nội dung tin nhắn..." class="form-control input_s" id="chat_message">
                        </div>
                    </div>
                    <div class="col-3 row align-items-center text-right justify-content-end">
                        <input type="file" name="data" id="file" class="d-none">
                        <label class="attachment m-0 mr-4 cursor-pointer" for="file">
                            <img src="/assets/img/upload.svg" width="30px" height="30px" />
                        </label>
                        <div class="like cursor-pointer" id="btn-like">
                            <img src="/assets/img/like.svg" width="30px" height="30px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-popup">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="modal-title">
                                        <h2>Create group</h2>
                                        <img src="/assets/img/LG.png" width="100px">
                                    </div>
                                    <div class="tab-pane active" id="create_group">
                                        <div class="submit_form">
                                            <input type="text" class="form-control" name="name_group" id="name_group" placeholder="Group name" required>
                                            <input type="text" class="form-control" name="email" id="search_email" placeholder="Enter email to search" required>
                                            <input type="hidden" name="list_user" value="[]" id="list_user" />
                                            <div class="text-white text-left" id="show_list_user"></div>
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <input name="captcha" type="text" placeholder="Enter result" id="captcha" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <img src="/captcha.php" class="recaptcha_form" />
                                                </div>
                                            </div>
                                            <button class="form-control submit_form_btn" id="create_room">Create</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </body>
    <?php include("footer.php"); ?>
    <script src="/assets/js/chat.js" type="text/javascript"></script>

    </html>
    <style>
        .user_room {
            padding: 10px 30px;
            cursor: pointer;
        }

        .main_chat {
            min-height: calc(100% - 130px);
            max-height: calc(100% - 130px);
            height: calc(100% - 130px);
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
            max-height: calc(100% - 110px);
            overflow: auto;

        }

        .badged_file {
            width: 100%;
            text-overflow: ellipsis;
            overflow: hidden;
            color: #ffffff;
        }

        .message_content {
            background: -webkit-linear-gradient(to right, #434343, #000000);
            background: linear-gradient(to right, #434343, #000000);
            padding: 10px;
        }

        .message_outer {
            color: #FFFFFF;
            margin-bottom: 5px;
            max-width: 50%;
        }

        .media-area>img {
            max-height: 300px;
        }

        .frame_list_user {
            position: relative;
            min-height: 100%;
        }

        .list_user {
            width: 100%;
            min-height: calc(100% - 110px);
            position: relative;
        }

        .user_setting {
            width: 100%;
            position: absolute;
            bottom: 0px;
        }

        .center_text_absolute {
            color: #696969;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .room_active {
            background-color: #434343;
        }

        .add_group {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
        }

        #show_list_user {
            width: 100%;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .reaction-area,
        .media-area {
            margin-bottom: 10px;
        }
        .message .trash{
            margin-top: 10px;
            margin-right: 10px;
            cursor: pointer;
            transition: all 0.5s;
            opacity: 0;
        }
        .message .trash>img{
            width: 25px;
            height: 25px;
        }
        .message:hover .trash{
            opacity: 1;
        }
        .deleted_ms{
            font-weight: bold;
            font-size: 80%;
            font-style: italic;
        }
    </style>
<?php
} else {
    header("Location: /view/login.php");
}
