<?php

    echo "<ul class='pagination pull-left margin-zero mt0'>";
    
    // Trang đầu
    if($page>1){
    
        $prev_page = $page - 1;
        echo "<li>";
            echo "<a href='{$page_url}page={$prev_page}'>";
                echo "<span style='margin:0 .5em;'>&laquo; Previous</span>"; //<< Previous
            echo "</a>";
        echo "</li>";
    }
    
    // Hành động kích chọn trang cụ thể sẽ đặt tại đây
    $total_pages = ceil($total_rows / $records_per_page);
    
    $range = 1; // phạm vi số link để hiển thị
    
    // hiển thị link xung quanh trang hiện tại
    $initial_num = $page - $range;
    $condition_limit_num = ($page + $range)  + 1;
    
    for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    
        if (($x > 0) && ($x <= $total_pages)) {
    
            // trang hiện tại
            if ($x == $page) {
                echo "<li class='active'>";
                    echo "<a href='javascript::void();'>{$x}</a>";
                echo "</li>";
            }
    
            // trường hợp không phải trang hiện tại
            else {
                echo "<li>";
                    echo " <a href='{$page_url}page={$x}'>{$x}</a> ";
                echo "</li>";
            }
        }
    }

    // Trang cuối
    if($page<$total_pages){
        $next_page = $page + 1;
    
        echo "<li>";
            echo "<a href='{$page_url}page={$next_page}'>";
                echo "<span style='margin:0 .5em;'>Next &raquo;</span>"; //Next >>
            echo "</a>";
        echo "</li>";
    }

    echo "</ul>";
?>