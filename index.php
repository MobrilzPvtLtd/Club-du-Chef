<?php
include "header.php";

include "home_page_inline_css.php";

?>

<?php

// Know current city

if(isset($_SESSION['city']))
{
    $CurrentCity = $_SESSION['city'];
}else{
    $CurrentCity = 'www';
}

if ($CurrentCity = $_SESSION['city']) {
    include "template/home/".$CurrentCity.".php";
}
?>


<?php
include "footer.php";
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo $webpage_full_link; ?>js/jquery.min.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/popper.min.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/jquery-ui.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/select-opt.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/blazy.min.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="<?php echo $webpage_full_link; ?>js/slick.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/custom.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/jquery.validate.min.js"></script>
<script src="<?php echo $webpage_full_link; ?>js/custom_validation.js"></script>
<?php
include "home_page_inline_js.php"
?>
<script>
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 250) {
            $(".hom-top").addClass("dmact");
        }
        else {
            $(".hom-top").removeClass("dmact");
        }
    });
    
    $('.travel-sliser').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false
            }
        }]

    });
    $('.travel-sliser-auto').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false
            }
        }]

    });

    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
            }
        }]

    });
//test
    $('.multiple-items2').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
            }
        }]

    });
    
    $('.multiple-items1').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
            }
        }]

    });
</script>
</body>

</html>