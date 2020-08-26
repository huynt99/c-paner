<div id="content-container">
    <div id="section-navigation">
        <ul class="navi">
            <?php
            if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                $cid = $_GET['cid'];
                $pid = NULL;
            } elseif(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $pid = $_GET['pid'];
                $cid = NULL;
            } else {
                $pid = NULL;
                $cid = NULL;
            }
            $sq = "SELECT cate_name, cat_id FROM `categories` ORDER BY position ASC";
            $qu = mysqli_query($con, $sq);

            // lấy category trong csdl
            while ($cate = mysqli_fetch_array($qu, MYSQLI_ASSOC)) {
                echo "<li><a href='index.php?cid={$cate['cat_id']}'";
                if ($cate['cat_id'] == $cid) echo "class='selected'";
                echo ">" .  $cate['cate_name'] . "</a>";

                //lấy pages trong csdl
                $sql = "SELECT cat_id, page_name, page_id FROM `pages` WHERE cat_id ={$cate['cat_id']} ORDER BY position ASC";
                $que = mysqli_query($con, $sql);

                echo "<ul class='pages'>";
                while ($page = mysqli_fetch_array($que, MYSQLI_ASSOC)) { 
                    echo "<li><a href='single.php?pid={$page['page_id']}'";
                    if($page['page_id'] == $pid) echo "class=''selected";
                    echo ">" . $page['page_name'] . "</a></li>";
                }
                echo "</ul>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
    <!--end section-navigation-->