<?php

// to show error codes
ini_set("display_errors", 1);

// call database connection file to use
require_once("./../dbconnect.php");
// call session config file to use its methods
require_once("./../sessionconfig.php");

$admin = null;
$messages = null;
$message = '';

if (!isset($_SESSION['email'])) {
    redirectto("./../login.php");
}

if(verifysession("user-login-success")){
    $message = getsession("user-login-success");
}

if(verifysession('email')) {
    $email = getsession('email');
    try {
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getunreadcount(){
    try{
        $conn = $GLOBALS['conn'];
        $sql = "SELECT COUNT(*) FROM messages WHERE status = 0";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function updatestatus(){
    try{
        $conn = $GLOBALS['conn'];
        $sql = "UPDATE messages SET status = 1 WHERE status = 0";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getmessages(){
    try{
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM messages ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$unreadcount = getunreadcount();
//echo $unreadcount;
$messages = getmessages();
updatestatus();
//var_dump($messages);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Contact Message</title>

    <!-- Fontfaces CSS-->
    <link href="./../../css/font-face.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="./../../public/libs/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="./../../public/libs/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/wow/animate.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="./../../public/libs/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="./../../css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop4">
            <div class="container">
                <div class="header4-wrap">
                    <div class="header__logo">
                        <a href="#">
                            <img src="./../../public/images/icon/logo-blue.png" alt="CoolAdmin" />
                        </a>
                    </div>
                    <div class="header__tool">
                        <div class="header-button-item has-noti js-item-menu">
                            <i class="zmdi zmdi-notifications"></i>
                            <div class="notifi-dropdown js-dropdown">
                                <div class="notifi__title">
                                    <p>You have 3 Notifications</p>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c1 img-cir img-40">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a email notification</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c2 img-cir img-40">
                                        <i class="zmdi zmdi-account-box"></i>
                                    </div>
                                    <div class="content">
                                        <p>Your account has been blocked</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c3 img-cir img-40">
                                        <i class="zmdi zmdi-file-text"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a new file</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__footer">
                                    <a href="#">All notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <div class="image">
                                    <?php if($admin['profile'] != null){ ?>
                                        <img src="./../../<?php echo $admin['profile'] ?>" alt="<?php echo $admin['name'] ?>" />
                                    <?php }else{ ?>
                                        <img src="./../../public/images/icon/avatar-01.jpg" alt="<?php echo $admin['name'] ?>" />
                                    <?php } ?>
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"><?php echo ucwords($admin['name']) ?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <?php if($admin['profile'] != null){ ?>
                                                    <img src="./../../<?php echo $admin['profile'] ?>" alt="<?php echo $admin['name'] ?>" />
                                                <?php }else{ ?>
                                                    <img src="./../../public/images/icon/avatar-01.jpg" alt="<?php echo $admin['name'] ?>" />
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?php echo ucwords($admin['name']) ?></a>
                                            </h5>
                                            <span class="email"><?php echo $admin['email'] ?></span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="./../logout.php">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP -->

        <!-- WELCOME-->
        <section class="welcome2 p-t-40 p-b-55">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="au-breadcrumb3">
                            <div class="au-breadcrumb-left">
                                <span class="au-breadcrumb-span">You are here:</span>
                                <ul class="list-unstyled list-inline au-breadcrumb__list">
                                    <li class="list-inline-item active">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="list-inline-item seprate">
                                        <span>/</span>
                                    </li>
                                    <li class="list-inline-item">Contact Messages</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="welcome2-inner m-t-60">
                            <div class="welcome2-greeting">
                                <h1 class="title-6">Hi
                                    <span>Admin</span>, Welcome back</h1>
                                <p>View Contact Messages Page</p>
                            </div>
                            <form class="form-header form-header2" action="" method="post">
                                <input class="au-input au-input--w435" type="text" name="search" placeholder="Search for datas &amp; reports...">
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END WELCOME-->

        <!-- PAGE CONTENT-->
        <div class="page-container3">
            <section class="alert-wrap p-t-70 p-b-70">
                <div class="container">
                    <!-- ALERT-->
<!--                    <div class="alert au-alert-success alert-dismissible fade show au-alert au-alert--70per" role="alert">-->
<!--                        <i class="zmdi zmdi-check-circle"></i>-->
<!--                        <span class="content">You successfully read this important alert message.</span>-->
<!--                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">-->
<!--                            <span aria-hidden="true">-->
<!--                                <i class="zmdi zmdi-close-circle"></i>-->
<!--                            </span>-->
<!--                        </button>-->
<!--                    </div>-->
                    <!-- END ALERT-->
                </div>
            </section>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3">
                            <!-- MENU SIDEBAR-->
                            <aside class="menu-sidebar3 js-spe-sidebar">
                                <nav class="navbar-sidebar2 navbar-sidebar3">
                                    <ul class="list-unstyled navbar__list border rounded">
                                        <li>
                                            <a href="dashboard.php">
                                                <i class="fas fa-tachometer-alt"></i>Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="eventmanagement.php">
                                                <i class="fas fa-calendar"></i>Events</a>
                                        </li>
                                        <li>
                                            <a href="membermanagement.php">
                                                <i class="fas fa-users"></i>Members</a>
                                        </li>
                                        <li class="active has-sub">
                                            <a href="contactmessage.php">
                                                <i class="fas fa-comments"></i>Messages</a>
                                            <?php if($unreadcount > 0){
                                                echo '<span class="inbox-num">'.$unreadcount.'</span>';
                                            } ?>
                                        </li>
                                    </ul>
                                </nav>
                            </aside>
                            <!-- END MENU SIDEBAR-->
                        </div>
                        <div class="col-xl-9">
                            <!-- PAGE CONTENT-->
                            <div class="page-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                            <div class="au-card-title" style="background-image:url('./../../public/images/bg-title-01.jpg');">
                                                <div class="bg-overlay bg-overlay--blue"></div>
                                                <h3>
                                                    <i class="zmdi zmdi-account-calendar"></i>Contact Messages</h3>
                                                <button class="au-btn-plus">
                                                    <i class="zmdi zmdi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="au-task js-list-load">
                                                <div class="au-task__title">
                                                    <p>All contact messages</p>
                                                </div>
                                                <div class="au-task-list js-scrollbar3">
                                                    <?php
                                                    $messagetotal = sizeof($messages);
                                                    $limit = $messagetotal / 2;
                                                    $counter = 1;
                                                    ?>
                                                    <?php foreach ($messages as $message){ ?>
                                                        <div class="au-task__item au-task__item--success <?php if($counter > $limit && $messagetotal >= 6){ echo "js-load-item"; }?>">
                                                            <div class="au-task__item-inner">
                                                                <h5 class="task">
                                                                    <span><?php echo ucwords($message['name']) ?></span>
                                                                    <?php if(!$message['status']){ ?>
                                                                        <span class="btn btn-sm btn-danger ml-3">Unread</span>
                                                                    <?php }?>
                                                                </h5>
                                                                <span class="time"><?php echo $message['datetime'] ?></span>
                                                                <p style="font-size: 14px;letter-spacing: 1px;margin-top: 5px"><?php echo $message['content'] ?></p>
                                                                <span style="font-size: 14px;letter-spacing: 1px;">(<?php echo $message['email'] ?>)</span>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        $counter++;
                                                    }
                                                    ?>
                                                </div>
                                                <?php if($messagetotal >= 6){ ?>
                                                    <div class="au-task__footer">
                                                        <button class="au-btn au-btn-load js-load-btn">load more</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="copyright">
                                            <p>Copyright © 2024 AUS. All rights reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT-->
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END PAGE CONTENT  -->

    </div>

    <!-- Jquery JS-->
    <script src="./../../public/libs/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="./../../public/libs/bootstrap-4.1/popper.min.js"></script>
    <script src="./../../public/libs/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="./../../public/libs/wow/wow.min.js"></script>
    <script src="./../../public/libs/animsition/animsition.min.js"></script>
    <script src="./../../public/libs/circle-progress/circle-progress.min.js"></script>
    <script src="./../../public/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="./../../public/libs/chartjs/Chart.bundle.min.js"></script>
    <script src="./../../public/libs/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="./../../js/main.js"></script>

</body>

</html>
<!-- end document-->