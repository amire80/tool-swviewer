<?php
header("Cache-Control: no-cache, no-stire, must-revalidate, max-age=0");
header('Content-Type: application/json; charset=utf-8');
session_name( 'SWViewer' );
session_start();
if ((isset($_SESSION['tokenKey']) == false) or (isset($_SESSION['tokenSecret']) == false) or (isset($_SESSION['userName']) == false)) {
    echo "Invalid request";
    session_write_close();
    exit(0);
}
$userName = $_SESSION['userName'];
session_write_close();

if (!isset($_POST["action"]) || !isset($_POST["query"])) {
    if (!isset($_GET["action"]) || !isset($_GET["query"]) || $_GET["action"] !== "get" || $_GET["query"] !== "all") {
        echo "Invalid request; dev. code 2";
        exit();
    }
}

$ts_pw = posix_getpwuid(posix_getuid());
$ts_mycnf = parse_ini_file("/data/project/swviewer/security/replica.my.cnf");
$db = new PDO("mysql:host=tools.labsdb;dbname=s53950__SWViewer;charset=utf8", $ts_mycnf['user'], $ts_mycnf['password']);
unset($ts_mycnf, $ts_pw);

if (!isset($_POST["action"])) {
    if ($_GET["action"] == "get" && $_GET["query"] = "all") {
        $q = $db->prepare('SELECT * FROM user WHERE name = :userName');
        $q->execute(array(':userName' => $userName));
        $result = $q->fetchAll();

        $response = ["blprojects" => $result[0]['blprojects'], "swmt" => $result[0]['swmt'], "sound" => $result[0]['sound'], "countqueue" => $result[0]['countqueue'], "onlyanons" => $result[0]['anons'], "mobile" => $result[0]['mobile'], "direction" => $result[0]['direction'], "rhand" => $result[0]['rhand'], "users" => $result[0]['users'], "wlusers" => $result[0]['wlusers'], "wlprojects" => $result[0]['wlprojects'], "namespaces" => $result[0]['namespaces'], "registered" => $result[0]['registered'], "new" => $result[0]['new'], "onlynew" => $result[0]['onlynew'], "editcount" => $result[0]['editscount'], "regdays" => $result[0]['regdays'], "theme" => $result[0]['theme']];
        echo json_encode($response);
        $db = null;
        exit();
    }
}

if ($_POST["action"] == "set") {
    if ($_POST["query"] == "theme") {
        if (isset($_POST['theme']) && isset($_POST["limit"])) {
            if ($_POST['theme'] >= "0" && $_POST['theme'] < $_POST["limit"]) {
                $q = $db->prepare('UPDATE user SET theme=:theme WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':theme' => $_POST['theme']));
            }
        }
    }

    if ($_POST["query"] == "swmt") {
        if (isset($_POST['swmt'])) {
            if ($_POST['swmt'] == "0" || $_POST['swmt'] == "1" || $_POST['swmt'] == "2") {
                $q = $db->prepare('UPDATE user SET swmt=:swmt WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':swmt' => $_POST['swmt']));
            }
        }
    }
        
    if ($_POST["query"] == "registered") {
        if (isset($_POST['registered'])) {
            if ($_POST['registered'] == "0" || $_POST['registered'] == "1") {
                $q = $db->prepare('UPDATE user SET registered=:registered WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':registered' => $_POST['registered']));
            }
        }
    }

    if ($_POST["query"] == "users") {
        if (isset($_POST['users'])) {
            if ($_POST['users'] == "0" || $_POST['users'] == "1" || $_POST['users'] == "2") {
                $q = $db->prepare('UPDATE user SET users=:users WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':users' => $_POST['users']));
            }
        }
    }

    if ($_POST["query"] == "anons") {
        if (isset($_POST['anons'])) {
            if ($_POST['anons'] == "0" || $_POST['anons'] == "1") {
                $q = $db->prepare('UPDATE user SET anons=:anons WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':anons' => $_POST['anons']));
            }
        }
    }

    if ($_POST["query"] == "rhand") {
        if (isset($_POST['rhand'])) {
            if ($_POST['rhand'] == "0" || $_POST['rhand'] == "1") {
                $q = $db->prepare('UPDATE user SET rhand=:rhand WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':rhand' => $_POST['rhand']));
            }
        }
    }

    if ($_POST["query"] == "mobile") {
        if (isset($_POST['mobile'])) {
            if ($_POST['mobile'] == "0" || $_POST['mobile'] == "1" || $_POST['mobile'] == "2" || $_POST['mobile'] == "3") {
                $q = $db->prepare('UPDATE user SET mobile=:mobile WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':mobile' => $_POST['mobile']));
            }
        }
    }

    if ($_POST["query"] == "newbies") {
        if (isset($_POST['sqlnew'])) {
            if ($_POST['sqlnew'] == "0" || $_POST['sqlnew'] == "1") {
                $q = $db->prepare('UPDATE user SET  new=:new WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':new' => $_POST['sqlnew']));
            }
        }
    }


    if ($_POST["query"] == "onlynew") {
        if (isset($_POST['onlynew'])) {
            if ($_POST['onlynew'] == "0" || $_POST['onlynew'] == "1") {
                $q = $db->prepare('UPDATE user SET  onlynew=:onlynew WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':onlynew' => $_POST['onlynew']));
            }
        }
    }

    if ($_POST["query"] == "direction") {
        if (isset($_POST['direction'])) {
            if ($_POST['direction'] == "0" || $_POST['direction'] == "1") {
                $q = $db->prepare('UPDATE user SET direction=:direction WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':direction' => $_POST['direction']));
            }
        }
    }

    if ($_POST["query"] == "sound") {
        if (isset($_POST['sound'])) {
            if ($_POST['sound'] == "0" || $_POST['sound'] == "1" || $_POST['sound'] == "2" || $_POST['sound'] == "4" || $_POST['sound'] == "4" || $_POST['sound'] == "5") {
                $q = $db->prepare('UPDATE user SET sound=:sound WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':sound' => $_POST['sound']));
            }
        }
    }

    if ($_POST["query"] == "numbers") {
        if (isset($_POST['editscount'])) {
            if (preg_match('/^[0-9]+$/', $_POST['editscount'])) {
                $q = $db->prepare('UPDATE user SET editscount=:editscount WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':editscount' => $_POST['editscount']));
            }
        }
        if (isset($_POST['regdays'])) {
            if (preg_match('/^[0-9]+$/', $_POST['regdays'])) {
                $q = $db->prepare('UPDATE user SET regdays=:regdays WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':regdays' => $_POST['regdays']));
            }
        }
        if (isset($_POST['countqueue'])) {
            if (preg_match('/^[0-9]+$/', $_POST['countqueue'])) {
                $q = $db->prepare('UPDATE user SET countqueue=:countqueue WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':countqueue' => $_POST['countqueue']));
            }
        }
    }

    if ($_POST["query"] == "namespaces") {
        if (isset($_POST['ns'])) {
            if (preg_match('/^[0-9,]+$/', $_POST['ns']) || $_POST['ns'] == null || $_POST['ns'] == "") {
                $q = $db->prepare('UPDATE user SET namespaces=:ns WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':ns' => $_POST['ns']));
            }
        }
    }

    if ($_POST["query"] == "whitelist") {
        if (isset($_POST['wlusers'])) {
            $q = $db->prepare('UPDATE user SET wlusers=:wlusers WHERE name =:userName');
            $q->execute(array(':userName' => $userName, ':wlusers' => $_POST['wlusers']));
        }
        if (isset($_POST['wlprojects'])) {
            if ($_POST['wlprojects'] == null || preg_match('/^[a-zA-Z_\-,]+$/', $_POST['wlprojects'])) {
                $q = $db->prepare('UPDATE user SET wlprojects=:wlprojects WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':wlprojects' => $_POST['wlprojects']));
            }
        }
    }
    
    if ($_POST["query"] == "blacklist") {
        if (isset($_POST['blprojects'])) {
            if ($_POST['blprojects'] == null || preg_match('/^[a-zA-Z_\-,]+$/', $_POST['blprojects'])) {
                $q = $db->prepare('UPDATE user SET blprojects=:blprojects WHERE name =:userName');
                $q->execute(array(':userName' => $userName, ':blprojects' => $_POST['blprojects']));
            }
        }
    }

}
$db = null;
exit();
?>