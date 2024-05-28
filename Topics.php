<!DOCTYPE html>
<html lang="en">
    <?php 
        $page_title = "Topics";
        include('Header.php');
        include('custom_functions/Database.php');

        $cookie_message = getCookieMessage();

        const MAX_TOPICS_PER_PAGE = 5;

        $sort_type = isset($_GET['Sort']) ? $_GET['Sort'] : 'Datetime';
        $current_page = isset($_GET['Page']) ? $_GET['Page'] : 1;

        $offset = ($current_page - 1) * MAX_TOPICS_PER_PAGE;
        $topics = get_displayed_topics(MAX_TOPICS_PER_PAGE, $offset, $sort_type);

        $page_ceil = ceil(get_topic_count() / MAX_TOPICS_PER_PAGE);
        $max_page = $page_ceil > 0 ? $page_ceil : 1; /* Account for 0 topics, ceil(0/5) returns 0 */
        $next_page = $current_page + 1;
        $prev_page = $current_page - 1;
    ?>
    <body>
        <?php include('NavBar.php'); ?>
        <div id="page-content">
            <div id="topics-content" class="main-content">
                <div class='table-positioning'>
                    <div class='above-table-content'>
                        <?php
                            echo "<div class='pager-section'>";
                            $params = $_GET;

                            if($prev_page > 0)
                            {
                                $params = array_merge( $_GET, array( 'Page' => $prev_page ) );
                                $new_query_string = http_build_query( $params );

                                echo "<a class='pager-button' href='Topics.php?$new_query_string'>&lt;</a>";
                            }
                            else
                            {
                                echo "<a class='pager-button disabled'>&lt;</a>";
                            }

                            echo "<p class='table-pager-text'>" . $current_page . " of $max_page</p>";

                            if($next_page <= $max_page)
                            {
                                $params = array_merge( $_GET, array( 'Page' => $next_page ) );
                                $new_query_string = http_build_query($params);

                                echo "<a class='pager-button' href='Topics.php?$new_query_string'>&gt;</a>";
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
                            <?php
                                $query_str = urlencode($_SERVER['QUERY_STRING']);
                                $base_redirect = "SortTable.php?Path=Topics";
                                $old_query_str = "&Query=$query_str";
                            ?>
                            <tr>
                                <th id='created-by-user-header'>
                                    <?php
                                        $sort_type = "&Sort=Username";
                                        $redirect = $base_redirect . $sort_type . $old_query_str;
                                    ?>
                                    <a href="<?php echo $redirect ?>">Created By User</a>
                                </th>

                                <th id='topic-name-header'>
                                    <?php
                                        $sort_type = "&Sort=Topic";
                                        $redirect = $base_redirect . $sort_type . $old_query_str;
                                    ?>
                                    <a href="<?php echo $redirect ?>">Topic Name</a>
                                </th>

                                <th id='date-created-header'>
                                    <?php
                                        $sort_type = "&Sort=Datetime";
                                        $redirect = $base_redirect . $sort_type . $old_query_str;
                                    ?>
                                    <a href="<?php echo $redirect ?>">Date Created</a>
                                </th>
                            </tr>
                            <?php                                
                                foreach($topics as $topic)
                                {
                                    $user = $topic['UserName'];
                                    $datetime = $topic['DateTime'];
                                    $topic_name = $topic['Topic'];
                                    $redirect = urlencode($topic_name);
                                    $topic_id = get_topic_id($topic_name);
                                    $topics_post_count = count_posts_in_topic($topic_id);

                                    echo "<tr>";
                                    echo "<td><div class='topic-user'>$user</div></td>";

                                    echo "<td>";
                                        echo "<div class='topic-name-section'>";
                                            echo "<div class='topic-name'><a href=\"Forum.php?Topic=$redirect\">$topic_name</a></div>";
                                            echo "<div class='topic-post-count'>";
                                                
                                                // https://commons.wikimedia.org/wiki/File:OOjs_UI_icon_message-constructive.svg
                                                // OOjs UI Team and other contributors, MIT <http://opensource.org/licenses/mit-license.php>, via Wikimedia Commons
                                                echo "<img class='post-count-img' src='images/envelope.svg'>";
                                                echo "<div class='post-count-number'>$topics_post_count</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</td>";

                                    echo "<td><div class='topic-date'>$datetime</div></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <?php
                        echo "<form class='create-topic' method = 'POST' action = 'AddTopic.php'>";
                        if(getCookieUser() == '')
                        {
                            echo "<p class='error'>You must be signed in to create a new topic.</p>";
                        }
                        else
                        {
                            echo "<div class='left-child'>";
                                echo "<p class='label'>Create a new topic: </p>";
                            echo "</div>";

                            echo "<div class='center-child'>";
                                echo "<input class='input' type='text' placeholder='Topic Name ' name='TopicName' autofocus>";
                                echo "<p class='error'>" . $cookie_message . "</p>";
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