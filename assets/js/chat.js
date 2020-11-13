function list_user_loader(id) {
    var object = $(id);
    $.ajax({
        url: "/moddle/user.php?action=get_list_user",
        success: function(e) {
            delete_loader_bar(id);
            e = JSON.parse(e);
            if (e.status == false)
                toastr.error(e.msg);
            e = e.data;
            for (i = 0; i < e.length; i++) {
                object.append('<div class="user_room room_chat" id="user_' + e[i].id + '" attr_for_type="user" attr_for_id="' + e[i].id + '"><div class="d-inline-block align-middle mr-2"><img src="' + e[i]["avatar"] + '" width="60px" height="60px" class="rounded-circle"></div><div class="d-inline-block align-middle"><h4>' + e[i]["fullname"] + '</h4><small>{{Tin nhắn cuối cùng}}</small></div></div>')
            }
        },
        error: function(e) {
            delete_loader_bar(id);
            error(e);
        }
    })
}

function error(e) {
    console.info(e);
    toastr.error("Connection to server error! Please try againt.");
}

function loader_bar(id) {
    $(id).append('<div class="loader bar"><div></div></div>');
}

function delete_loader_bar(id) {
    $(id).find('.loader.bar').remove();
}

function render_message(e, object) {
    if (e.type == "typping") {
        object.prepend('<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="' + e.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="reaction-area"><div id="wave"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></div></div></div>');
    } else {
        if (e.ower_user == "me") {
            if (e.message_text == '[like]') {
                object.prepend('<div class="message row col-12 justify-content-end mt-2"><div class="message_outer"><div class="reaction-area"><div class="like cursor-pointer"><img src="/assets/img/like.svg" width="45px" height="45px" /></div></div><div class="text-right"><small>' + time_intel(e.timestamp) + '</small></div></div></div>');
            } else {
                object.prepend('<div class="message row col-12 justify-content-end mt-2"><div class="message_outer"><div class="message_content rounded"><div class="message_text">' + e.message_text + '</div></div><div class="text-right"><small>' + time_intel(e.timestamp) + '</small></div></div></div>');
            }
        } else {
            if (e.message_text == '[like]') {
                object.prepend('<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="' + e.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="reaction-area"><div class="like cursor-pointer"><img src="/assets/img/like.svg" width="45px" height="45px" /></div></div><div class="text-right"><small>' + time_intel(e.timestamp) + '</small></div></div></div>');
            } else {
                object.prepend('<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="' + e.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="message_content rounded"><div class="message_text">' + e.message_text + '</div></div><div class="text-right"><small>' + time_intel(e.timestamp) + '</small></div></div></div>');
            }
        }
    }
}

function append_render_message(e, object) {
    $("#no_message").remove();
    if (e.type == "typing") {
        if (e.room_id == window.room_id) {
            var who_el = object.find("#typing_" + e.info_user.user_id);
            time = new Date().getTime();
            if (who_el.length == 0) {
                object.append('<div class="message row col-12 justify-content-start mt-2" id="typing_' + e.info_user.user_id + '" attr_for_user="' + e.info_user.user_id + '" attr_for_time="' + time + '"><div class="mr-2"><img src="' + e.info_user.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="reaction-area"><div id="wave"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></div></div></div>');
            } else {
                who_el = object.find("#typing_" + e.info_user.user_id);
                who_el.attr("attr_for_time", time);
            }
            var handle = setTimeout(function() {
                current_time = new Date().getTime();
                who_el = object.find("#typing_" + e.info_user.user_id);
                if (current_time - 5000 > who_el.attr("attr_for_time")) {
                    who_el.remove();
                }
            }, 5000);
        }
    } else {
        if (e.info_user.user_id == window.user_id) {
            if (e.info_user.message_text == '[like]') {
                object.append('<div class="message row col-12 justify-content-end mt-2"><div class="message_outer"><div class="reaction-area"><div class="like cursor-pointer"><img src="/assets/img/like.svg" width="45px" height="45px" /></div></div><div class="text-right"><small>' + time_intel(e.info_user.timestamp) + '</small></div></div></div>');
            } else {
                object.append('<div class="message row col-12 justify-content-end mt-2"><div class="message_outer"><div class="message_content rounded"><div class="message_text">' + e.info_user.message_text + '</div></div><div class="text-right"><small>' + time_intel(e.info_user.timestamp) + '</small></div></div></div>');
            }
        } else {
            if (e.info_user.message_text == '[like]') {
                object.append('<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="' + e.info_user.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="reaction-area"><div class="like cursor-pointer"><img src="/assets/img/like.svg" width="45px" height="45px" /></div></div><div class="text-right"><small>' + time_intel(e.info_user.timestamp) + '</small></div></div></div>');
            } else {
                object.append('<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="' + e.info_user.avatar + '" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="message_content rounded"><div class="message_text">' + e.info_user.message_text + '</div></div><div class="text-right"><small>' + time_intel(e.info_user.timestamp) + '</small></div></div></div>');
            }
        }
    }
}

function load_data_message(id, room_id, type) {
    loader_bar(id);
    window.room_id = room_id;
    var object = $(id);
    $.ajax({
        url: "/moddle/message.php?action=get_list_message&room_id=" + room_id + "&type=" + type,
        success: function(e) {
            delete_loader_bar(id);
            e = JSON.parse(e);
            if (e.status) {
                $("#title_message").html(e.name_room);
                if (e.data.length > 0) {
                    object.html('');
                    for (i = 0; i < e.data.length; i++) {
                        render_message(e.data[i], object);
                    }
                }
            } else {
                toastr.error("Error when start chat, please try againt.");
            }
            window.room_id = e.room_id;
            window.history.pushState(null, "LocalSocical", "/index.php?thread_id=" + e.room_id);
        },
        error: function(e) {
            delete_loader_bar(id);
            error(e);
        }
    })
}

function send_message(text, room_id) {
    $.ajax({
        url: "/moddle/message.php?action=send_message",
        method: "POST",
        data: "room_id=" + room_id + "&message=" + text,
        success: function(e) {

        },
        error: function(e) {
            error(e);
        }
    })
}

function time_ago(time, return_day) {
    var now = new Date().getTime() / 1000;
    var diff = now - time;
    d = diff / 60 / 60 / 24;
    h = diff / 60 / 60;
    m = diff / 60;
    if (d > 1) {
        ago = new Date(time * 1000);
        if (return_day)
            return Math.floor(d) + " days";
        else
            return
    } else if (h > 1) {
        return Math.round(h) + " hours";
    } else if (m > 1) {
        return Math.round(m) + " minutes";
    } else {
        return "just";
    }
}

function time_intel(time) {
    var now = new Date();
    var ago = new Date(time * 1000);
    hour = ago.getHours();
    minute = ago.getMinutes();
    date = ago.getDate();
    month = ago.getMonth() + 1;
    if (ago.getFullYear() == now.getFullYear()) {
        return hour + ":" + minute + " " + date + "/" + month;
    } else {
        return hour + ":" + minute + " " + date + "/" + month + "/" + ago.getFullYear();
    }
}

function create_modal() {

}
async function search_user(email) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/moddle/user.php?action=search_user",
            method: "POST",
            data: "email=" + email,
            success: function(e) {
                resolve(e);
            },
            error: function(e) {
                error(e);
                reject(e);
            }
        });
    });
}

function ping_typing(room_id) {
    $.ajax({
        url: "/moddle/message.php?action=ping_typing",
        method: "POST",
        data: "room_id=" + room_id
    });
}

function create_badge_user(id, data) {
    var object = $(id);
    object.append('<div class="d-inline-block badged_user"><div class="d-flex rounded-pill p-2 border align-items-center"><img src="' + data["avatar"] + '" width="30px" height="30px" class="rounded-circle"/><div class="ml-2">' + data["fullname"] + '</div><div class="ml-2 close_badge cursor-pointer" aria-hidden="true" attr_for_id="' + data["id"] + '">×</div></div></div>');
}
$(document).ready(function() {
    list_user_loader(".list_user");
    $("#search_email").on('keypress', async function(e) {
        if (e.which == 13) {
            loader_bar("#modal-form>div");
            let res_user = await search_user($(this).val());
            res_user = JSON.parse(res_user);
            if (res_user.status) {
                var res_user_id = res_user["data"][0];
                var current_value = JSON.parse($("#list_user").val());
                if (current_value.length == 0) {
                    current_value.push(res_user_id["id"]);
                    $("#list_user").val(JSON.stringify(current_value));
                    create_badge_user("#show_list_user", res_user_id);
                } else {
                    for (i = 0; i < current_value.length; i++) { //Kiểm tra người dùng đã có chưa?
                        if (current_value[i] == res_user_id["id"])
                            break;
                        if (i == current_value.length - 1) { //Thêm người dùng vào modal;
                            current_value.push(res_user_id["id"]);
                            $("#list_user").val(JSON.stringify(current_value)); //Thêm value vào ô input
                            create_badge_user("#show_list_user", res_user_id); //Tạo DOM hiển thị kết quả tìm kiếm
                        }
                    }
                }
            } else {
                toastr.error(res_user.msg);
            }
            $(this).val('');
            delete_loader_bar("#modal-form>div");
            return false;
        }
    });
    $("#modal-form").on("click", ".close_badge", function() {
        var current_value = JSON.parse($("#list_user").val());
        var id = $(this).attr("attr_for_id");
        for (i = 0; i < current_value; i++) {
            if (current_value[i] == id) {
                current_value.splice(i, 1);
                $("#list_user").val(JSON.stringify(current_value));
                break;
            }
        }
        $(this).parents(".badged_user").remove();
    });
    $("#create_room").click(function() {
        $.ajax({
            url: "/moddle/message.php?action=create_room",
            method: "POST",
            data: "name_group=" + $("#name_group").val() + "&list_user=" + $("#list_user").val() + "&captcha=" + $("#captcha").val(),
            beforeSend: function(e) {
                loader_bar("#modal-form>div");
            },
            success: function(e) {
                $(".recaptcha_form").attr("src", "/captcha.php?v=" + new Date().getTime());
                delete_loader_bar("#modal-form>div");
                e = JSON.parse(e);
                if (e.status) {
                    window.location.href = "/index.php?thread_id=" + e.room_id;
                } else {
                    toastr.error(e.msg);
                }
            },
            error: function(e) {
                delete_loader_bar("#modal-form>div");
                error(e);
            }
        })
    });
    last_typing = new Date().getTime();
    $("#chat_message").on('keypress', function(e) {
        if (e.which == 13) {
            send_message($(this).val(), window.room_id);
            $(this).val('');
            return false;
        } else {
            if (new Date().getTime() - 4000 > last_typing) {
                last_typing = new Date().getTime();
                ping_typing(window.room_id);
            }
        }
    });
    $("#btn-like").click(function() {
        send_message('[like]', window.room_id);
    });
    $(".list_user").on("click", ".room_chat", function() {
        load_data_message(".message_list", $(this).attr("attr_for_id"), $(this).attr("attr_for_type"));
        $(".room_chat").removeClass("room_active");
        $(this).addClass("room_active");
    });
    if (window.room_id != '') {
        load_data_message(".message_list", window.room_id, "room");
    }
});
$(function() {
    "use strict";
    window.WebSocket = window.WebSocket || window.MozWebSocket;
    if (!window.WebSocket) {
        //Không hỗ trợ wss
        return;
    }
    // open connection
    var connection = new WebSocket('ws://127.0.0.1:1338/?auth_key=' + auth_token);
    connection.onerror = function(error) {
        //Error
    }
    connection.onmessage = function(message) {
        message = JSON.parse(message.data);
        if (message.type == "show_message") {
            append_render_message(message, $(".message_list"))
        } else if (message.type == "typing") {
            append_render_message(message, $(".message_list"))
        } else if (message.type == "seen") {
            $("#seen_mark").attr({ "id": "" }).find('p').remove();
            $(".from_me:last-child").attr({ "id": "seen_mark" }).find('.message_body').append('<p class="small width_100 text-right">Đã xem</p>');
        } else if (message.type == "delete_message") {
            $(".from_other[id_for='" + message["id"] + "']").find(".message").html(message["message"]);
        }
    };
});