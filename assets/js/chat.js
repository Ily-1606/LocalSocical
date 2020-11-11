var chat_other = '<div class="message row col-12 justify-content-end mt-2"><div class="message_outer"><div class="message_content rounded"><div class="message_text">{{text_here}}</div></div><div class="text-right"><small>{{time}}</small></div></div></div>';
var chat = '<div class="message row col-12 justify-content-start mt-2"><div class="mr-2"><img src="/assets/img/male.png" width="40px" height="40px" class="rounded-circle"></div><div class="message_outer"><div class="message_content rounded"><div class="message_text">{{text_here}}</div></div><div class="text-right"><small>{{time}}</small></div></div></div>';
function list_user_loader(id){
    var object = $(id);
    $.ajax({
        url: "/moddle/user.php?action=get_list_user",
        success: function(e){
            object.html('');
            e = JSON.parse(e);
            if(e.status == false)
                toastr.error(e.msg);
            e = e.data;
            for(i = 0; i < e.length; i++){
                object.append('<div class="user_room" id="user_'+e[i].id+'"><div class="d-inline-block align-middle mr-2"><img src="'+e[i]["avatar"]+'" width="60px" height="60px" class="rounded-circle"></div><div class="d-inline-block align-middle"><h4>'+e[i]["fullname"]+'</h4><small>{{Tin nhắn cuối cùng}}</small></div></div>')
            }
        }
    })
}
$(document).ready(function(){
    list_user_loader(".list_user");
})