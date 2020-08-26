<?php
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');
?>
<div id="content">
    <h2>Manage Pages</h2>
    <table>
        <thread>
            <?php
                if(isset($_GET['sort'])){
                    switch ($_GET['sort']) {
                        case 'pname':
                            $order_by = "page_name";
                            break;
                        
                        case 'by':
                            $order_by = "first_name";
                            break;
                    
                        case 'on':
                            $order_by = "post_on";
                            break;
                                    
                        default:
                            $order_by = "page_name";
                            break;
                    }
                } else {
                    $order_by = "page_name";
                }
            ?>
            <tr>

                <th><a href="view-pages.php?sort=pname">Page name</a></th>
                <th><a href="view-pages.php?sort=by">Posted by</a></th>
                <th><a href="view-pages.php?sort=on">Posted on</a></th>
                <th>Content</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thread>
        <tbody>
            <?php
            $que = "SELECT p.page_id, p.page_name, CONCAT_WS(' ', u.first_name, u.last_name) AS name, DATE_FORMAT(p.post_on, '%b %d %Y') AS date, p.content";
            $que .= " FROM pages AS p";
            $que .= " JOIN users AS u";
            $que .= " USING(user_id)";
            $que .= " ORDER BY {$order_by}";
            $res = resultQuery($que);
            while ($row = mysqli_fetch_array($res)) :
            ?>
                <tr>
                    <td><?php echo $row['page_name'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['content'] ?></td>
                    <td><a class="edit" href="edit-pages.php?pid=<?php echo $row['page_id'];?>">Edit</a></td>
                    <td><a class="delete" href="delete-pages.php?pid=<?php echo $row['page_id'];?>&pagename=<?php echo $row['page_name'];?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>