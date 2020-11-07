<!DOCTYPE html>
<html lang="en">

<head>

     <title>Ứng dụng chat</title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <link rel="stylesheet" href="/assets/bootstrap/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="/assets/css/responsive.css">
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="/assets/css/type.css">
     <link rel="stylesheet" href="/assets/toastr/css/toastr.min.css">

</head>

<body>


     <section class="navbar custom-navbar navbar-fixed-top bg-dark" role="navigation">
          <div class="container">




               <section class="navbar custom-navbar navbar-fixed-top col-12 bg-dark" role="navigation">
                    <div class="container">

                         <div class="navbar-header">

                              <img src="/assets/img/LG.png" width="100px">

                         </div>

                         <ul class="nav navbar-nav navbar-right">

                              <li class="section-btn"><a href="#" data-toggle="modal" data-target="#modal-form">Sign in / Join</a></li>
                         </ul>


                    </div>
               </section>

          </div>

          </div>
     </section>
     <div class="col-12 text-center">
          <img src="/assets/img/wc.png" class="auto_reponsive">
     </div>

     <div class="col-12 text-center">
          <img src="/assets/img/chat.gif" class="auto_reponsive">
          <img src="/assets/img/a.png" class="auto_reponsive"></p>
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
                                             <h2>Chat</h2>
                                             <img src="/assets/img/LG.png" width="100px">
                                        </div>


                                        <ul class="nav nav-tabs" role="tablist">
                                             <li class="active"><a href="#sign_up" aria-controls="sign_up" role="tab" data-toggle="tab">Create an account</a></li>
                                             <li><a href="#sign_in" aria-controls="sign_in" role="tab" data-toggle="tab">Sign In</a></li>
                                        </ul>
                                        <div class="tab-content">
                                             <div role="tabpanel" class="tab-pane fade in active" id="sign_up">
                                                  <form action="#" method="post">
                                                       <input type="text" class="form-control" name="Firstname" placeholder="First Name" required>
                                                       <input type="text" class="form-control" name="Lastname" placeholder="Last Name" required>
                                                       <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                       <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                       <input type="password" class="form-control" name="re_password" placeholder="Re-password" required>
                                                       <input type="telephone" class="form-control" name="telephone" placeholder="Telephone" required>
                                                       <div class="form-group text-white">
                                                            <div class="form-check form-check-inline">
                                                                 <input class="form-check-input" type="radio" name="gender" id="gender_1" value="1">
                                                                 <label class="form-check-label" for="gender_1">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                 <input class="form-check-input" type="radio" name="gender" id="gender_2" value="2">
                                                                 <label class="form-check-label" for="gender_2">Female</label>
                                                            </div>
                                                       </div>
                                                       <input type="text" class="form-control" name="Securecode" placeholder="Secure Code" required>

                                                       <div class="row align-items-center">
                                                            <div class="col">
                                                                 <input name="captcha" type="text" placeholder="Nhập kết quả bên" class="form-control">
                                                            </div>
                                                            <div class="col">
                                                                 <img src="/captcha.php" class="recaptcha_form" />
                                                            </div>
                                                       </div>
                                                       <input name="submit" type="submit" class="form-control" value="Regsister">
                                                  </form>
                                             </div>

                                             <div role="tabpanel" class="tab-pane fade in" id="sign_in">
                                                  <form action="#" method="post">
                                                       <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                       <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                       <div class="row align-items-center">
                                                            <div class="col">
                                                                 <input name="captcha" type="text" placeholder="Nhập kết quả bên" class="form-control">
                                                            </div>
                                                            <div class="col">
                                                                 <img src="/captcha.php" class="recaptcha_form" />
                                                            </div>
                                                       </div>
                                                       <input name="submit" type="submit" class="form-control" value="Login">
                                                  </form>
                                                  <a href="#">Login with face recognition?</a>
                                                  </form>
                                             </div>
                                        </div>
                                   </div>

                              </div>
                         </div>
                    </div>

               </div>
          </div>
     </section>


     <script src="/assets/jquery/jquery.js"></script>
     <script src="/assets/bootstrap/dist/js/bootstrap.min.js"></script>

     <script src="/assets/js/custom.js"></script>
     <script src="/assets/toastr/js/toastr.min.js"></script>
     <script type='text/javascript'>
          var pictureSrc = "/assets/img/br.png";
          var pictureWidth = 25; //
          var pictureHeight = 25;
          var numFlakes = 15; //số lượng bông tuyết
          var downSpeed = 0.01; //tốc độ rơi của bông tuyết (phần màn hình trên 100 mili giây)
          var lrFlakes = 15; // tốc độ bông tuyết bay từ bên này sang bên kia


          if (typeof(numFlakes) != 'number' || Math.round(numFlakes) != numFlakes || numFlakes < 1) {
               numFlakes = 10;
          }
          //vẽ bông tuyết
          for (var x = 0; x < numFlakes; x++) {
               if (document.layers) {
                    document.write('<layer id="snFlkDiv' + x + '"><imgsrc="' + pictureSrc + '" height="' + pictureHeight + '"width="' + pictureWidth + '" alt="*" border="0"></layer>');
               } else {
                    document.write('<div style="position:absolute; z-index:9999;"id="snFlkDiv' + x + '"><img src="' + pictureSrc + '"height="' + pictureHeight + '" width="' + pictureWidth + '" alt="*"border="0"></div>');
               }
          }
          // tính toán các vị trí ban đầu (trong các phần của kích thước cửa sổ trình duyệt)
          var xcoords = new Array(),
               ycoords = new Array(),
               snFlkTemp;
          for (var x = 0; x < numFlakes; x++) {
               xcoords[x] = (x + 1) / (numFlakes + 1);
               do {
                    snFlkTemp = Math.round((numFlakes - 1) * Math.random());
               } while (typeof(ycoords[snFlkTemp]) == 'number');
               ycoords[snFlkTemp] = x / numFlakes;
          }

          //now animate
          function flakeFall() {
               if (!getRefToDivNest('snFlkDiv0')) {
                    return;
               }
               var scrWidth = 0,
                    scrHeight = 0,
                    scrollHeight = 0,
                    scrollWidth = 0;
               // tìm cài đặt màn hình cho tất cả các biến thể. làm điều này mọi lúc cho phép thay đổi kích thước và cuộn
               if (typeof(window.innerWidth) == 'number') {
                    scrWidth = window.innerWidth;
                    scrHeight = window.innerHeight;
               } else {
                    if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
                         scrWidth = document.documentElement.clientWidth;
                         scrHeight = document.documentElement.clientHeight;
                    } else {
                         if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
                              scrWidth = document.body.clientWidth;
                              scrHeight = document.body.clientHeight;
                         }
                    }
               }
               if (typeof(window.pageYOffset) == 'number') {
                    scrollHeight = pageYOffset;
                    scrollWidth = pageXOffset;
               } else {
                    if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
                         scrollHeight = document.body.scrollTop;
                         scrollWidth = document.body.scrollLeft;
                    } else {
                         if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
                              scrollHeight = document.documentElement.scrollTop;
                              scrollWidth = document.documentElement.scrollLeft;
                         }
                    }
               }
               //Di chuyển bông tuyết đến vị trí mới
               for (var x = 0; x < numFlakes; x++) {
                    if (ycoords[x] * scrHeight > scrHeight - pictureHeight) {
                         ycoords[x] = 0;
                    }
                    var divRef = getRefToDivNest('snFlkDiv' + x);
                    if (!divRef) {
                         return;
                    }
                    if (divRef.style) {
                         divRef = divRef.style;
                    }
                    var oPix = document.childNodes ? 'px' : 0;
                    divRef.top = (Math.round(ycoords[x] * scrHeight) + scrollHeight) + oPix;
                    divRef.left = (Math.round(((xcoords[x] * scrWidth) - (pictureWidth / 2)) + ((scrWidth / ((numFlakes + 1) * 4)) * (Math.sin(lrFlakes * ycoords[x]) - Math.sin(3 * lrFlakes * ycoords[x])))) + scrollWidth) + oPix;
                    ycoords[x] += downSpeed;
               }
          }


          function getRefToDivNest(divName) {
               if (document.layers) {
                    return document.layers[divName];
               }
               if (document[divName]) {
                    return document[divName];
               }
               if (document.getElementById) {
                    return document.getElementById(divName);
               }
               if (document.all) {
                    return document.all[divName];
               }
               return false;
          }

          window.setInterval('flakeFall();', 100);
     </script>
     <script>
          $(function() {
               $("#submit_form").submit(function() {
                    $.ajax({
                         url: $(this).attr("action"),
                         method: $(this).attr("method"),
                         success: function(e) {
                              e = JSON.parse(e);
                              if (e.status) {
                                   toastr.success(e.msg);
                              } else
                                   toastr.error(e.msg);
                         },
                         error: function(e) {
                              console.info(e);
                              toastr.error("Có lỗi khi kết nối với máy chủ!");
                         }
                    });
                    return false;
               });
          })
     </script>


</body>

</html>