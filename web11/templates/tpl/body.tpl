
<style>
  .carousel-item {
      height: 100vh;
      min-height: 350px;
      background: no-repeat center center scroll;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
  }
</style>
<{if $mainSlides}>
  <header>
    <div id="mainSlide" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">        
        <{foreach $mainSlides as $index => $mainSlide}>
          <li data-target="#mainSlide" data-slide-to="<{$index}>" <{if $index==0}>class="active"<{/if}>></li>
        <{/foreach}>
      </ol>
      <div class="carousel-inner" role="listbox">
        <{foreach $mainSlides as $index => $mainSlide}>
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item <{if $index==0}>active<{/if}>" style="background-image: url('<{$mainSlide.pic}>')">
            <div class="carousel-caption d-none d-md-block">
              <h2 class="display-4">
                <a class="btn btn-light btn-xl js-scroll-trigger" href="<{$mainSlide.url}>" <{if $mainSlide.target}>target="_blank"<{/if}> style="background-color:rgba(255,255,255,0.5)">
                  <{$mainSlide.title}>
                </a>
              </h2>
              <{if $mainSlide.content}>
                <p class="lead"><{$mainSlide.content}></p>
              <{/if}>
            </div>
          </div>
        <{/foreach}>
      </div>
      <a class="carousel-control-prev" href="#mainSlide" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#mainSlide" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>

<{/if}>
  

  <!-- About Section -->
  <section class="page-section bg-primary" id="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">We've got what you need!</h2>
          <hr class="divider light my-4">
          <p class="text-white-50 mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! Choose one of our open source, free to download, and easy to use themes! No strings attached!</p>
          <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Get Started!</a>
        </div>
      </div>
    </div>
  </section>

  <!-- prod list -->
  <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">點餐</h2>
      <hr class="divider my-4">
      <div class="row">
        
        <{foreach $rows as $row}>
            
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
              <a href="#">
                <img class="card-img-top" src="<{$row.prod}>" alt="<{$row.title}>">
              </a>
              <div class="card-body text-center">
                <h4 class="card-title">
                  <a href="#"><{$row.title}>：<{$row.price}>元</a>
                </h4>
                
                <a href="javascript:void(0)" onclick="addCart(<{$row.sn}>);">加入購物車</a>
              </div>
            </div>
          </div>
        <{foreachelse}>
        <{/foreach}>
      

      </div>
    </div>
  </section>
  
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.css">
    <script src="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.js"></script>
    <script>
      function addCart(sn){
        Swal.fire({
          title: '你確定嗎？',
          text: "您將無法還原！",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '是的，刪除它！',
          cancelButtonText: '取消'
          }).then((result) => {
          if (result.value) {
            document.location.href="index.php?op=addCart&sn="+sn;
          }
        })
      }
    </script>

  <!-- Portfolio Section -->
  <section id="portfolio">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/1.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/1.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/2.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/2.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/3.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/3.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/4.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/4.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/5.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/5.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<{$xoImgUrl}>img/portfolio/fullsize/6.jpg">
            <img class="img-fluid" src="<{$xoImgUrl}>img/portfolio/thumbnails/6.jpg" alt="">
            <div class="portfolio-box-caption p-3">
              <div class="project-category text-white-50">
                Category
              </div>
              <div class="project-name">
                Project Name
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="page-section bg-dark text-white">
    <div class="container text-center">
      <h2 class="mb-4">Free Download at Start Bootstrap!</h2>
      <a class="btn btn-light btn-xl" href="https://startbootstrap.com/themes/creative/">Download Now!</a>
    </div>
  </section>