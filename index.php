<?php
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    $rootName = $_SERVER['HTTP_HOST'];
    $url = "{$_SERVER['REQUEST_URI']}";
    $directoryUrl = __DIR__ . "$url";
    $scan = scandir($directoryUrl);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $url ?> </title>
    <link href="<?php echo $root ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $root ?>/assets/css/sticky-footer.css" rel="stylesheet">
    <script src="<?php echo $root ?>/assets/js/bytes.js"></script>
</head>

<body class="bg-light">
<div class="nav-scroller bg-white navbar-white shadow" style="position: fixed; top: 0; width: 100%; z-index: 1000">
    <nav class="nav nav-underline" aria-label="breadcrumb">
        <a class="navbar-brand breadcrumb-item active" style="padding-left: 15px;"
           href="<?php echo $root ?>"><?php echo $rootName ?></a>
        <?php
        $arrayBC = explode("/", $url);
        $end = array_slice($arrayBC, -2, 1);
        $id = 0;
        $BCurls = "";
        foreach ($end as $aaa) {
            $ab = $aaa;
        }
        foreach ($arrayBC as $urls) {
            $BCurls = $BCurls . $urls . '/';
            if ($end != $urls && $urls != "") {
                ?>
                <a
                    <?php if ($ab != $urls) { ?>
                        href="<?php echo $root . $BCurls; ?>"
                        <?php $status = "active";
                    } else {
                        $status = "text-muted";
                    } ?>
                        style="background: transparent; padding-left: 5px; padding-right: 5px;"
                        class="nav-link breadcrumb-item <?php echo $status ?>"><?php echo $urls;
                    ?></a>
                <?php
            }
        }
        ?>
    </nav>
</div>

<main role="main" class="container" style="padding-top: 45px; padding-bottom: 20px">
    <div class="row">

        <div class="col">
            <button id="php" class="btn d-flex align-items-center p-3 my-3 text-white-50 bg-info rounded-left box-shadow" style="width: 100%">
                <div class="p-2">
                    <img class="mr-3" src="<?php echo $root ?>/assets/image/php-logo.svg" alt="PHP" width="90"
                        height="90">
                </div>
                <div class="p-2 flex-grow-1">
                    <div class="lh-100 text-center">
                        <h6 class="mb-0 text-white lh-100">Version</h6>
                        <small class="text-white"><?php echo phpversion() ?></small>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <div class="row">

        <div class="col" style="padding-bottom: 20px">
            <div class="card rounded box-shadow">
                <br>
                <h4 class="card-title text-center">Directory</h4>
                <hr width="100%">
                <div class="container">
                    <?php
                    $dc = 0;
                    $dt = 0;
                    function directorySize($dir)
                    {
                        $size = 0;
                        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
                            $size += is_file($each) ? filesize($each) : directorySize($each);
                        }
                        return $size;
                    }

                    function directoryItems($dir)
                    {
                        $items = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
                        return iterator_count($items);
                    }

                    foreach ($scan as $file) {
                        if (is_dir($directoryUrl . $file)) {
                            if ($file == "." or $file == "..") {
                            } else {
                                ++$dc;
                                $dt = $dt + directorySize($directoryUrl . $file); ?>
                                <div class="card">
                                    <div class="card-body">
                                        <img src="<?php echo $root ?>/assets/image/icons/folder.svg"
                                             style="width: 45px; height: 45px">
                                        <a href="<?php echo $file ?>"><?php echo $file ?></a>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary text-dark"
                                                        disabled><script>document.write(bytesToSize(<?php echo directorySize($directoryUrl . $file)?>));</script></button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary text-dark"
                                                        disabled><?php echo directoryItems($directoryUrl . $file) . " items inside" ?></button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary text-dark"
                                                        disabled><span data-livestamp="<?php echo filemtime($directoryUrl . $file) ?>"></span></button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php }
                        }
                    }
                    if ($dc == 0) { ?>
                        <h5 class="text-muted text-center ">No directories found in <?php echo $url ?></h5>
                    <?php } ?>
                </div>
                <div class="card-footer d-block text-center mt-3">
                    <div class="text-muted"><script>document.write(bytesToSize(<?php echo $dt ?>));</script> total
                        of <?php echo $dc ?> <?php if ($dc == 0 || $dc == 1) {
                            echo "directory";
                        } elseif ($dc > 1) {
                            echo "directories";
                        } ?>.
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card rounded box-shadow">
                <br>
                <h4 class="card-title text-center">File</h4>
                <hr width="100%">
                <div class="container">
                    <?php
                    $fc = 0;
                    $fs = 0;

                    foreach ($scan as $file) {
                        if (!is_dir($directoryUrl . $file)) {
                            ++$fc;
                            $fs = $fs + filesize($directoryUrl . $file);
                            $fileExt = explode(".", $file);
                            $Cext = end($fileExt);

                            ?>

                            <div class="card">
                                <div class="card-body">
                                    <img src="<?php echo $root ?>/assets/image/icons/file.svg"
                                         style="width: 45px; height: 45px" alt="">
                                    <a href="<?php echo $file ?>"><?php echo $file ?></a>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary text-dark"
                                                    disabled><script>document.write(bytesToSize(<?php echo filesize($directoryUrl . $file);?>));</script></button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary text-dark" disabled>
                                                    <span
                                               data-livestamp="<?php echo filemtime($directoryUrl . $file) ?>"></span></button>
                                               <?php if (pathinfo($file, PATHINFO_EXTENSION) != NULL) {
                                                   ?>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary text-dark" disabled>
                                                    <?php echo pathinfo($file, PATHINFO_EXTENSION);?>
                                                    </button>
                                                   <?php
                                               }
                                               ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        <?php }
                    }
                    if ($fc == 0) { ?>
                        <h5 class="text-muted text-center ">No files found in <?php echo $url ?></h5>
                    <?php } ?>
                </div>
                <div class="card-footer d-block text-center mt-3">
                    <div class="text-muted"><script>document.write(bytesToSize(<?php echo $fs ?>));</script> total
                        of <?php echo $fc ?> <?php if ($fc == 0 || $fc == 1) {
                            echo "file";
                        } elseif ($fc > 1) {
                            echo "files";
                        } ?>.
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

<script src="<?php echo $root ?>/assets/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $root?>/assets/js/jquery.min.js"><\/script>')</script>
<script src="<?php echo $root ?>/assets/js/popper.min.js"></script>
<script src="<?php echo $root ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo $root ?>/assets/js/moment.js"></script>
<script src="<?php echo $root ?>/assets/js/livestamp.min.js"></script>
<script>
document.getElementById("php").onclick = function() {
    window.location.href = "/phpinfo.php";
};
document.getElementById("mysql").onclick = function() {
    window.location.href = "/phpmyadmin/";
};
</script>

</body>

<footer class="footer">
    <div class="container text-center" style="padding-top: 15px">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary text-dark" disabled><?php echo apache_get_version();?></button>
            <button type="button" class="btn btn-sm btn-outline-secondary text-dark" disabled><?php echo $_SERVER['SERVER_NAME'] ?>:<?php echo $_SERVER['SERVER_PORT'] ?></button>
        </div>
    </div>
</footer>

</html>

<main hidden>