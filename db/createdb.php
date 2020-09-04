<?php
$conn = mysqli_connect('localhost', 'dkmmysql', 'root');

$que = "CREATE DATABASE IF NOT EXISTS huy_izcms";
$conn->query($que);
mysqli_select_db($conn, 'huy_izcms');


// categories
$categ = "  CREATE TABLE IF NOT EXISTS `categories`(
            `cat_id` int(11) PRIMARY KEY AUTO_INCREMENT ,
            `user_id` int(11) NOT NULL,
            `cate_name`varchar(100) NOT NULL,
            `position` TINYINT NOT NULL
            );
        ";
$conn->query($categ);
$que = "INSERT INTO `categories` (`cat_id`, `user_id`, `cate_name`, `position`) VALUES
        (1, 1, 'History', 1),
        (2, 1, 'Wordpress', 2),
        (3, 1, 'HTML', 3),
        (4, 1, 'CSS', 4),
        (5, 1, 'Review truyện tranh', 5);
        ";
$conn->query($que);

$que = "ALTER TABLE categories AUTO_INCREMENT=6;";
$conn->query($que);

// pages
$pages = "  CREATE TABLE IF NOT EXISTS `pages`(
            `page_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `user_id` INT(11) NOT NULL,
            `cat_id` INT(11) NOT NULL,
            `page_name` VARCHAR(150) NOT NULL,
            `content` TEXT NOT NULL,
            `position` TINYINT NOT NULL,
            `post_on` TIMESTAMP NOT NULL,
            INDEX(`user_id`, `cat_id`, `position`, `post_on`)
    );
";
$conn->query($pages);

$que = "INSERT INTO `pages` (`page_id`, `user_id`, `cat_id`, `page_name`, `content`, `position`, `post_on`) VALUES
        (1, 1, 2, 'wordpress', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.                ', 2, '2020-08-25 07:57:09'),
        (2, 1, 5, 'bách luyện thành thần', 'Đúng như tên gọi Bách Luyện Thành Thần là một bộ truyện xuyên suốt theo 1 nhân vật chính sẽ liên tục đối mặt với các sự kiện, cường giả, cấp bậc võ học cao hơn và tôi luyện bản thân liên tục cho đến khi đạt tới đỉnh cao nhất của toàn bộ thể giới này.\r\n\r\nLiên tục tập luyện, chiến đấu, vượt qua những cuộc chiến sinh tử không ngừng nghỉ để đi lên, luôn gặp vận may sắp đặt, luôn gặp cơ duyên trời cho để tạo thành 1 đấng sáng thế mạnh nhất có thể tồn tại.\r\n\r\nĐiểm đặt biệt của bộ truyện là xây dựng cấu trúc cầu thang cho nhân vật chính đột phá liên tục liên tục không ngừng nghĩ mà có thể kéo dài tới hơn 3000 chương, một sự sáng tạo gọi là kinh thiên động địa.\r\n\r\nMình đọc dần từ chương 800 trở lên và mang cảm giác là sắp tới hồi kết thúc, nhưng không hề, sự kiện cứ liên tục tăng lên, tăng lên vượt rất xa khả năng tưởng tượng của người đọc, thậm chí mình k thể nào tưởng tượng ra nó có thể xây dựng tới nhiều cấp bậc cầu thang đi lên như vậy, một cố truyện cực kỳ hoàn hảo và cực kỳ phù hợp với sở thích cá nhân của mình.                ', 5, '2020-08-25 07:47:08'),
        (3, 1, 5, 'võ luyện đỉnh phong', 'Câu chuyện xoay quanh nhân vật tên là Dương Khai, hắn vốn là một đệ tử thí luyện ở Lăng Tiêu Các. Nhưng thật ra ban đầu hắn chỉ là một tên đệ tử chuyên dùng để sai vặt, quét rác… Cứ ngỡ tương lai của hắn cũng không mấy sáng sủa cho đến khi Dương Khai vô tin nhặt được một bí kíp Hắc thư thần bí. Nó chính là mấu chốt để cuộc đời Dương Khai lật sang một trang mới.\r\n\r\nTừ một tên sai vặt, tu luyện đánh đổi để bước đến bục danh vọng, trở thành vị anh hùng vang danh tứ phương, người người ca tụng, mỹ nữ bao quanh. Thế gian bắt đầu nổi sóng, một tên quét rác tầm thường có thể trở thành anh hùng trứ danh thiên hạ? Một tên hầu sai vặt thấp hèn lại chiếm luôn cả những mỹ nhân sắc nước hương trời? Vì sao Dương Khai lại được người ta nói đến như vậy?\r\n\r\nNhưng không có thành công nào là đến một cách dễ dàng. Ban đầu đúng là có chút may mắn khi nhặt được cuốn bí thư nhưng để đạt được thành tựu như ngày hôm nay chính là sự đánh đổi rất nhiều của Dương Khai.\r\n\r\nĐầu tiên chính là mồ hôi công sức, cả máu mà nước mắt đều dùng để đổi lại được từng chút kinh nghiệm, thành công. Điều phải chấp nhận đánh đổi để thành công chính là sự cô độc và lẻ loi. Bao nhiêu người vây quanh hắn như vậy, nhưng khi tiệc tàn bên cạnh hắn còn lại những ai? Càng cao thì con người ta càng cô độc.\r\n\r\nCô độc, tịch mịch chính là để đánh đổi lấy đỉnh cao của võ học. Sống trong nghịch cảnh, phát triển trong tuyệt địa, bất khuất không bỏ cuộc, mới có thể phá vỡ được cực đạo của võ thuật.\r\n\r\nBởi trong thế giới của Vũ Luyện Điên Phong, đỉnh cao nhất là võ đạo, cô độc, mạnh mẽ, và kiên trì. Có như thế mới có thể phá vỡ những quy tắc tầm thường, trở thành huyền thoại trong giới võ đạo.\r\n                ', 5, '2020-08-25 07:56:32'),
        (4, 1, 3, 'dvd HTML made by izweb', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).                                ', 3, '2020-08-25 07:55:56'),
        (6, 1, 4, 'Css animation', 'It’s fair to wonder why we would want to review CSS in the first place. A review is yet another step that adds time and cost and effort and all that other stuff that seems to hold us up from shipping a product.', 4, '2020-08-25 08:04:37'),
        (7, 1, 4, 'Css animation', 'It’s fair to wonder why we would want to review CSS in the first place. A review is yet another step that adds time and cost and effort and all that other stuff that seems to hold us up from shipping a product.', 4, '2020-08-25 09:21:23'),
        (8, 1, 1, 'template ', 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with: “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.” The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content. The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it\'s seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.', 1, '2020-08-26 04:31:15');
        ";
$conn->query($que);

$que = "ALTER TABLE pages AUTO_INCREMENT=9;";
$conn->query($que);

// users
$users = "  CREATE TABLE IF NOT EXISTS `users`(
            `user_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `first_name` VARCHAR(30) NOT NULL,
            `last_name` VARCHAR(30) NOT NULL,
            `email` VARCHAR(80) NOT NULL UNIQUE, 
            `pass` VARCHAR(32) NOT NULL,
            `website` VARCHAR(60),
            `yahoo` VARCHAR(80),
            `bio` TEXT,
            `avatar` VARCHAR(30),
            `user_lever` TINYINT DEFAULT 1, 
            `active` VARCHAR(60),
            `registrantion_date` TIMESTAMP NOT NULL,
            INDEX(`registrantion_date`)
    );
";
$conn->query($users);

$que = "INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `website`, `yahoo`, `bio`, `avatar`, `user_lever`, `active`, `registrantion_date`) VALUES
        (1, 'Huy', 'Nguyễn', 'nth@gmail.com', '1234', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00 00:00:00');
        ";
$conn->query($que);

$que = "ALTER TABLE users AUTO_INCREMENT=2;";
$conn->query($que);

// commnents
$comments = " CREATE TABLE IF NOT EXISTS `comments`(
            `comment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `page_id` INT(11) NOT NULL,
            `author` VARCHAR(80) NOT NULL,
            `email` VARCHAR(80) NOT NULL,
            `comment` TEXT NOT NULL,
            `comment_date` TIMESTAMP,
            INDEX(`page_id`)
    );
";
$conn->query($comments);

//dong csdl
mysqli_close($conn);