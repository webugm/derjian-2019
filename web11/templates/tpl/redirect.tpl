<{if $redirect}>
  <!-- 
    https://sweetalert2.github.io/
  -->
  <script src="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.css"> 
  <script>
    window.onload = function(){
      Swal.fire({
        icon: 'success',
        title: "<{$message}>",
        showConfirmButton: false,
        timer: <{$time}>
      })
    }
  </script>
<{/if}>