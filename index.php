<?php include("core/header.php");?>
<div class="main">
    <div class="content" >
        <div class="highlight" style="grid-area:highlight">
            <?php echo headerify("Highlights","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateHighlights();?>
            </div>
        </div>
        <div class="General" style="grid-area:general">
            <?php echo headerify("general","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateCatUi("general");?>

            </div>
        </div>
        <div class="programming" style="grid-area:programming">
            <?php echo headerify("programming","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateCatUi("programming");?>
            </div>
        </div>
        <div class="security" style="grid-area:security">
            <?php echo headerify("security","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateCatUi("security");?>
            </div>
        </div>
        <div class="electronics" style="grid-area:electronics">
            <?php echo headerify("electronics","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateCatUi("electronics");?>
            </div>
        </div>
        <div class="project" style="grid-area:project">
            <?php echo headerify("projects","class='sec-hdr' ");?>
            <div class="box-content">
                <?php populateCatUi("project");?>
            </div>
        </div>
    </div>
</div>
    <link rel="stylesheet" href="static/css/style.css">
<?php include("core/footer.php");?>