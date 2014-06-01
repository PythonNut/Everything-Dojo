<?php 
include('include/include.php');
include('include/header.php'); 
?>
<body>

<?php include('include/login-bar.php'); ?>
<div id="index-content">
    <div id="index-content-inner">
        <div class="index-row">
            <a href=<?php echo "\"" . URL_DATABASE . "\""; ?> class="index-item">
                <div class="index-item" id="index-database">
                    <div class="index-text">
                        <span class="index-title">DATABASE</span>
                        <br />
                        <span class="index-text">A collection of AoPS Blog CSS themes for your perusal.</span>
                    </div>
                </div>
            </a>
            <a href=<?php echo "\"" . URL_THEMIZER . "\""; ?> class="index-item">
                <div class="index-item" id="index-themizer">
                    <div class="index-text">
                        <span class="index-title">THEMIZER</span>
                        <br />
                        <span class="index-text">Want to customize a theme for yourself? Then themeizer is the tool for you!</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="clear-40"></div>
        <div class="index-row">
            <a href=<?php echo "\"" . URL_TRYIT . "\""; ?> class="index-item">
                <div class="index-item" id="index-tryit">
                    <div class="index-text">
                        <span class="index-title">TRY-IT</span>
                        <br />
                        <span class="index-text">Want to try out a theme before you actually use it on your blog? Give it a try with this tool!</span>
                    </div>
                </div>
            </a>
            <a href=<?php echo "\"" . URL_DISCUSS . "\""; ?> class="index-item">
                <div class="index-item" id="index-discuss">
                    <div class="index-text">
                        <span class="index-title">DISCUSS</span>
                        <br />
                        <span class="index-text">Come join our community of fellow AoPS bloggers and stylists!</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div id="index-footer"><?php echo COPYRIGHT; ?></div>

</body>
</html>