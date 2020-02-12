
  <!-- signup MODAL -->
  <div class="modal fade" id="signup" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title">註冊帳號</h3>
        </div>
        <div class="modal-body">
          
          <form action="index.php" method="POST" role="form" id="signupForm">
            <div class="form-group">
              <label for="name">姓名</label>
              <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
              <label for="pass">密碼</label>
              <input type="password" class="form-control" id="pass" name="pass">
            </div>
            
            <div class="form-group">
              <label for="confirmPass">確認密碼</label>
              <input type="password" class="form-control" id="confirmPass" name="confirmPass">
            </div>

            <div class="form-group">
              <label class="control-label" id="captchaOperation"></label>
              <input type="text" class="form-control" name="captcha" />
            </div>
            <{$token}>
            <button type="submit" class="btn btn-primary btn-block">註冊</button>
            <input type="hidden" value="signup" name="op">
          </form>

        </div>
      </div>
    </div>
  </div>
  
  <!-- login MODAL -->
  <div class="modal fade" id="login" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title">登入</h3>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST" role="form" id="loginForm">

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
              <label for="pass">密碼</label>
              <input type="password" class="form-control" id="pass" name="pass">
            </div>

            <{$token}>

            <button type="submit" class="btn btn-primary btn-block">登入</button>
            <input type="hidden" value="login" name="op">
          </form>          
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      // Generate a simple captcha
      function randomNumber(min, max) {
          return Math.floor(Math.random() * (max - min + 1) + min);
      };
      $('#captchaOperation').html([randomNumber(1, 50), '+', randomNumber(1, 50), '='].join(' '));

      $('#signupForm').bootstrapValidator({
          //live: 'disabled',//
          message: '此值無效',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            name: {
              validators: {
                notEmpty: {
                  message: '必填'
                }
              }
            },
            email: {
              validators: {
                notEmpty: {
                  message: '必填'
                },
                emailAddress: {
                  message: '請輸入正確的email'
                },
                remote: {
                  type: 'POST',
                  url: 'index.php?op=ajaxCheckEmail',
                  message: '這個email已經有人使用',
                  delay: 1000
                }
              }
            },
            pass: {
              validators: {
                notEmpty: {
                  message: '必填'
                },
                identical: {
                  field: 'confirmPass',
                  message: '密碼及其確認密碼不一樣'
                },
                different: {
                  field: 'email',
                  message: '密碼不能與email相同'
                }
              }
            },
            confirmPass: {
              validators: {
                  notEmpty: {
                    message: '必填'
                  },
                  identical: {
                    field: 'pass',
                    message: '密碼及其確認密碼不一樣'
                  },
                  different: {
                    field: 'email',
                    message: '密碼不能與email相同'
                  }
              }
            },
            captcha: {
              validators: {
                callback: {
                  message: '錯誤的答案',
                  callback: function(value, validator) {
                    var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                    return value == sum;
                  }
                }
              }
            }
          }
      });

      $('#loginForm').bootstrapValidator({
          //live: 'disabled',//
          message: '此值無效',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            email: {
              validators: {
                notEmpty: {
                  message: '必填'
                },
                emailAddress: {
                  message: '請輸入正確的email'
                }
              }
            },
            pass: {
              validators: {
                notEmpty: {
                  message: '必填'
                }
              }
            }
          }
      });
    });
  </script>