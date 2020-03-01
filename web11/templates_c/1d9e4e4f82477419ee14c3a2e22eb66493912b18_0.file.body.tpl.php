<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-02 02:45:40
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\body.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e5c02d42f39d9_53874106',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d9e4e4f82477419ee14c3a2e22eb66493912b18' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\body.tpl',
      1 => 1583088313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e5c02d42f39d9_53874106 (Smarty_Internal_Template $_smarty_tpl) {
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

  <!-- prod list -->
  <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">點餐</h2>
      <hr class="divider my-4">
      <div class="row">
        
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
            
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
              <a href="#">
                <img class="card-img-top" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['prod'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
">
              </a>
              <div class="card-body text-center">
                <h4 class="card-title">
                  <a href="#"><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
：<?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
元</a>
                </h4>
                
                <a href="javascript:void(0)" onclick="addCart(<?php echo $_smarty_tpl->tpl_vars['row']->value['sn'];?>
);">加入購物車</a>
              </div>
            </div>
          </div>
        <?php
}
} else {
?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      

      </div>
    </div>
  </section>
  
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.css">
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
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
    <?php echo '</script'; ?>
>

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
