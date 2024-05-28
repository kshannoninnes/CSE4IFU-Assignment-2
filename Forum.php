<!DOCTYPE html>
<html lang="en">
    <?php
        $page_title = $_GET['Topic'];
        include('Header.php');
        include('custom_functions/Database.php');
        include('custom_functions/Error.php');

        const MAX_POSTS_PER_PAGE = 10;

        /* echo "<head><title><?php echo '$page_title'; ?></title></head>"; Check this with validator */

        $current_page = isset($_GET['Page']) ? $_GET['Page'] : 1;

        $topic = $_GET['Topic'];
        $topic_id = get_topic_id($topic);
        
        if(! $topic_id)
        {
            abort_and_redirect("Invalid topic name, please choose from the list above", "Topics.php");
        }

        $offset = ($current_page - 1) * MAX_POSTS_PER_PAGE;
        $current_page_posts = get_displayed_posts(MAX_POSTS_PER_PAGE, $offset, $topic_id);

        $page_ceil = ceil(count_posts_in_topic($topic_id) / MAX_POSTS_PER_PAGE);
        $max_page = $page_ceil > 0 ? $page_ceil : 1; /* Account for 0 posts, ceil(0/10) returns 0 */
        $next_page = $current_page + 1;
        $prev_page = $current_page - 1;
    ?>
    <body>
        <?php include('NavBar.php'); ?>
        <div id="page-content">
            <div id="forum-content" class="main-content">
                <div class='table-positioning'>
                    <div class='above-table-content'>
                        <a id='return-to-topics-link' href='Topics.php'>Return to Topics</a>
                        <?php                                
                            echo "<div class='pager-section'>";
                            $params = $_GET;

                            if($prev_page > 0)
                            {
                                $params = array_merge( $_GET, array( 'Page' => $prev_page ) );
                                $new_query_string = http_build_query( $params );
                                
                                echo "<a class='pager-button' href='Forum.php?$new_query_string'>&lt;</a>";
                            }
                            else
                            {
                                echo "<a class='pager-button disabled'>&lt;</a>";
                            }

                            echo "<p class='table-pager-text'>$current_page of $max_page</p>";

                            if($next_page <= $max_page)
                            {
                                $params = array_merge( $_GET, array( 'Page' => $next_page ) );
                                $new_query_string = http_build_query( $params );

                                echo "<a class='pager-button' href='Forum.php?$new_query_string'>&gt;</a>";
                            }
                            else
                            {
                                echo "<a class='pager-button disabled'>&gt;</a>";
                            }
                            echo "</div>";
                        ?>
                    </div>
                    <div class='table-background'>
                        <table class='main-table'>
                            <tr>
                                <th id='post-user-header'>User</th>
                                <th id='post-name-header'>Post</th>
                                <th id='post-date-header'>Date</th>
                                <th id='post-likes-header'>Likes</th>
                            </tr>

                            <?php

                                foreach($current_page_posts as $post)
                                {
                                    $username = $post['UserName'];
                                    $first_name = $post['FirstName'];
                                    $last_name = $post['SurName'];
                                    $datetime = $post['DateTime'];
                                    $text = $post['Post'];
                                    $tag = $post['Tag'];
                                    $likes = $post['Likes'];
                                    $post_id = $post['PostID'];

                                    echo "<tr>";
                                    echo "<td><div class='post-user'>$username<br><sup>$first_name $last_name</sup></div></td>";

                                    echo "<td><div class='post-body'>";
                                    echo "<p class='post'>$text</p>";
                                    echo "<div class='half-border'></div>"; // Introduce a div acting as a border spanning 50% of the post body td cell
                                    echo "<p class='tag_display'>$tag</p>";
                                    echo "</div></td>";

                                    echo "<td class='post-date'>$datetime</td>";

                                    if($cookieUser != "")
                                    {
                                        $redirect_url = basename($_SERVER['REQUEST_URI']);
                                        echo "<td class='post-likes'>$likes ";
                                        echo "<a href='postLike.php?Redirect=" . urlencode($redirect_url) . "&PostID=$post_id'>";
                                        echo "<img class='like-button' src='images/arrow_up.svg'>";
                                        echo "</a>";
                                        echo "</td>";
                                    }
                                    else
                                    {
                                        echo "<td class='post-likes'>$likes</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <?php
                        echo "<form class='create-post' method = 'POST' action = 'AddPost.php?Topic=$topic'>";
                        if(getCookieUser() == '')
                        {
                            echo "<p class='error'>You must be signed in to create a new post.</p>";
                        }
                        else
                        {
                            echo "<div class='left-child'>";
                            echo "<p class='label'>Create a new post: </p>";
                            echo "</div>";
                            echo "<div class='center-child'>";
                            echo "<input class='input' type='text' placeholder='Post Name' name='Post' autofocus required>";
                            echo "<p class='error'>" . getCookieMessage() . "</p>";
                            echo "</div>";
                            echo "<div class='right-child'>";
                            echo "<button class='custom-button' type='submit' action='POST'>Submit</button>";
                            echo "</div>";
                        }
                        echo "</form>";
                    ?>
                </div>
            </div>
        </div>

    <?php include "Footer.php"; ?>
    </body>
</html>