<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Hello, world!</title>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </head>
  <body>
    <style>
      .form-signin {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        margin: 0 auto;
      }      
    </style>
    <div class="container mt-5">
      <form class="form-signin" action="<{$smarty.server.SCRIPT_NAME}>" method="post">
        <h1 class="h3 mb-3 font-weight-normal">會員登入</h1>
        <div class="mb-3">
          <label for="name" class="sr-only">帳號</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="請輸入帳號"  required>
        </div>
        <div class="mb-3">
          <label for="pass" class="sr-only">密碼</label>
          <input type="password" name="pass" id="pass" class="form-control" placeholder="請輸入密碼" required>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" name="remember" id="remember" > 記住我
          </label>
          
        </div>
        <input type="hidden" name="op" id="op" value="login">
        <button class="btn btn-lg btn-primary btn-block" type="submit">會員登入</button>
        <div>
          您還沒還沒註冊嗎？請 <a href="#">點選此處註冊您的新帳號</a>。
        </div>
      </form>
    </div>

  </body>
</html>