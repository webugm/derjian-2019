<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-28 19:41:11
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\body.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e58fc571399d3_17847490',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d9e4e4f82477419ee14c3a2e22eb66493912b18' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\body.tpl',
      1 => 1582890068,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e58fc571399d3_17847490 (Smarty_Internal_Template $_smarty_tpl) {
?>
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
<?php if ($_smarty_tpl->tpl_vars['mainSlides']->value) {?>
  <header>
    <div id="mainSlide" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">        
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mainSlides']->value, 'mainSlide', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['mainSlide']->value) {
?>
          <li data-target="#mainSlide" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['index']->value == 0) {?>class="active"<?php }?>></li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </ol>
      <div class="carousel-inner" role="listbox">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mainSlides']->value, 'mainSlide', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['mainSlide']->value) {
?>
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item <?php if ($_smarty_tpl->tpl_vars['index']->value == 0) {?>active<?php }?>" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['mainSlide']->value['pic'];?>
')">
            <div class="carousel-caption d-none d-md-block">
              <h2 class="display-4">
                <a class="btn btn-light btn-xl js-scroll-trigger" href="<?php echo $_smarty_tpl->tpl_vars['mainSlide']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['mainSlide']->value['target']) {?>target="_blank"<?php }?> style="background-color:rgba(255,255,255,0.5)">
                  <?php echo $_smarty_tpl->tpl_vars['mainSlide']->value['title'];?>

                </a>
              </h2>
              <?php if ($_smarty_tpl->tpl_vars['mainSlide']->value['content']) {?>
                <p class="lead"><?php echo $_smarty_tpl->tpl_vars['mainSlide']->value['content'];?>
</p>
              <?php }?>
            </div>
          </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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

<?php }?>
  

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

  <!-- Services Section -->
  <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">At Your Service</h2>
      <hr class="divider my-4">
      <div class="row">
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-gem text-primary mb-4"></i>
            <h3 class="h4 mb-2">Sturdy Themes</h3>
            <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
            <h3 class="h4 mb-2">Up to Date</h3>
            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-globe text-primary mb-4"></i>
            <h3 class="h4 mb-2">Ready to Publish</h3>
            <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-heart text-primary mb-4"></i>
            <h3 class="h4 mb-2">Made with Love</h3>
            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
  <section id="portfolio">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/1.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/1.jpg" alt="">
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
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/2.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/2.jpg" alt="">
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
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/3.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/3.jpg" alt="">
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
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/4.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/4.jpg" alt="">
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
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/5.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/5.jpg" alt="">
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
          <a class="portfolio-box" href="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/fullsize/6.jpg">
            <img class="img-fluid" src="<?php echo $_smarty_tpl->tpl_vars['xoImgUrl']->value;?>
img/portfolio/thumbnails/6.jpg" alt="">
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
  </section><?php }
}
