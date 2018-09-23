<?php
    /* Adds a specified post to the favorites list */
    function setFavPost($id) {
        include "includes/db_config.inc.php";
        $db = new PostsGateway($connection);
        $records = $db->findViaJoin('i');
        foreach($records as $post) {
            if($id == $post['PostID']) {
                $fav = unserialize($_COOKIE['fav']);
                $size = sizeof($fav);
                for($i=0;$i<$size;$i++) {
                    if($id == $fav[$i][3] && $fav[$i][0] == 'post') {
                        $dup = true;   
                    } else if($id != $fav[$i][3]){
                        $dup = false;
                    }
                }
                if($dup == false) {
                    array_push($fav, ['post', $post['ImageID'], $post['Title'], $post['PostID']]);
                    setCookie('fav', serialize($fav), 0);
                } else if($dup == true) {
                    header('Location: single-post.php?id=' . $id . '&dup=true');
                }
            }
        }
    }
    
    /* Adds a specified image to the favorites list */
    function setFavImg($id) {
        include "includes/db_config.inc.php";
        $db = new ImagesGateway($connection);
        $records = $db->findAll();
        foreach($records as $img) {
            if($id == $img['ImageID']) {
                $fav = unserialize($_COOKIE['fav']);
                $size = sizeof($fav);
                for($i=0;$i<$size;$i++) {
                    if($id == $fav[$i][3] && $fav[$i][0] == 'img') {
                        $dup = true;
                    } else if ($id != $fav[$i[3]]) {
                        $dup = false;
                    }
                }
                if($dup == false) {
                    array_push($fav, ['img', $img['Path'], $img['Title'], $img['ImageID']]);
                    setCookie('fav', serialize($fav), 0);
                } else if($dup == true) {
                    header('Location: single-image.php?id=' . $id . '&dup=true');
                }
            }
        }
    }
    
    /* Removes a specified post in the favorites list */
    function removeFavPost($id) {
        $fav = unserialize($_COOKIE['fav']);
        $count=sizeof($fav);
        for($i=0;$i<$count;$i++) {
            if($fav[$i][0] == 'post') {
                $search = $fav[$i];
                $find = array_search($id, $search);
                if($find !== false) {
                    array_splice($fav, $i, 1);;
                    setCookie('fav', serialize($fav), 0);
                    break;
                }
            }
        }
        header('Location: show-fav.php');
    }
    
    /* Removes a specified image in the favorites list */
    function removeFavImg($id) {
        $fav = unserialize($_COOKIE['fav']);
        $count=sizeof($fav);
        for($i=0;$i<$count;$i++) {
            if($fav[$i][0] == 'img') {
                $search = $fav[$i];
                $find = array_search($id, $search);
                if($find !== false) {
                    array_splice($fav, $i, 1);;
                    setCookie('fav', serialize($fav), 0);
                    break;
                }
            }
        }
        header('Location: show-fav.php');
    }
    
    /* Clears the whole favorites list and create a blank list */
    function removeFavAll() {
        $fav = [];
        setCookie('fav', serialize($fav), -3600);
        header('Location: show-fav.php');
    }
?>