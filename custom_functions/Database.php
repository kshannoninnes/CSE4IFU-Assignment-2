<?php

/* Core Queries */
const GET_USERID = 'SELECT UserID FROM User WHERE UserName = ? COLLATE NOCASE;';
const GET_TOPICID = 'SELECT TopicID FROM Topic WHERE Topic = ?;';

const INSERT_POST = 'INSERT INTO Post (UserID, Post, DateTime, TopicID) VALUES (?,?,?,?);';
const INSERT_USER = 'INSERT INTO User (UserName, FirstName, SurName, Tag) VALUES (?,?,?,?);';
const INSERT_TOPIC = 'INSERT INTO Topic (TopicID, UserID, DateTime, Topic) VALUES (NULL, ?, ?, ?);';

const USER_EXISTS = 'SELECT COUNT(1) FROM User WHERE UserName = ? COLLATE NOCASE;';
const TOPIC_EXISTS = 'SELECT COUNT(1) FROM "Topic" WHERE "Topic" LIKE ?;';

const COUNT_TOPICS = 'SELECT COUNT(TopicID) FROM Topic;';
const COUNT_POSTS = 'SELECT COUNT(Post.PostID) FROM Post WHERE Post.TopicID = ?;';

const GET_TOPICS = [
    'Username' => 'SELECT * FROM Topic INNER JOIN User ON Topic.UserID=User.UserID ORDER BY Username ASC LIMIT ? OFFSET ?',
    'Topic' => 'SELECT * FROM Topic INNER JOIN User ON Topic.UserID=User.UserID ORDER BY Topic ASC LIMIT ? OFFSET ?;',
    'Datetime' => 'SELECT * FROM Topic INNER JOIN User ON Topic.UserID=User.UserID ORDER BY DateTime DESC LIMIT ? OFFSET ?;'
];
const GET_POSTS = 'SELECT * FROM Post INNER JOIN User ON User.UserID = Post.UserID WHERE Post.TopicID = ? ORDER BY Post.PostID desc LIMIT ? OFFSET ?;';

/* Features */
const UPDATE_POST_LIKES = 'UPDATE Post SET Likes = Likes + 1 WHERE PostID = ?;';
const GET_TOP_POST = 'SELECT UserName,Post FROM Post INNER JOIN User ON Post.UserID=User.UserID ORDER BY Post.Likes desc LIMIT 1;';

############### SELECT QUERIES ###############

function user_exists($username)
{
    $count = _select(USER_EXISTS, [$username]);

    return $count[0]['COUNT(1)'] ? true : false; # Count sql queries always return an array with 1 element containing the count
}

function topic_exists($topic)
{
    $count = _select(TOPIC_EXISTS, [$topic]);

    return $count[0]['COUNT(1)'] ? true : false;
}

function get_user_id($username)
{
	$row = _select(GET_USERID, [$username]);

	return count($row) > 0 ? $row[0]['UserID'] : [];
}

function get_topic_id($topic)
{
    $row = _select(GET_TOPICID, [$topic]);
	
    return count($row) > 0 ? $row[0]['TopicID'] : [];
}

function get_topic_count()
{
    $count = _select(COUNT_TOPICS);

    return $count[0]['COUNT(TopicID)'];
}

function count_posts_in_topic($topic_id)
{
    $count = _select(COUNT_POSTS, [$topic_id]);

    return $count[0]['COUNT(Post.PostID)'];
}

function get_displayed_topics($limit, $offset, $sort_col)
{
    return _select(GET_TOPICS[$sort_col], [$limit, $offset]);
}

function get_displayed_posts($limit, $offset, $topic_id)
{
    return _select(GET_POSTS, [$topic_id, $limit, $offset]);
}

function get_top_post()
{
    $top_post = _select(GET_TOP_POST);

    return count($top_post) > 0 ? $top_post[0] : [];
}

############### INSERT QUERIES ###############

function insert_user($username, $first_name, $last_name, $tag)
{
    _insert(INSERT_USER, [$username, $first_name, $last_name, $tag]);
}

function insert_post($user_id, $post, $date, $topic_id)
{
    _insert(INSERT_POST, [$user_id, $post, $date, $topic_id]);
}

function insert_topic($user_id, $date, $topic)
{
    _insert(INSERT_TOPIC, [$user_id, $date, $topic]);
}

############### UPDATE QUERIES ###############

function update_likes($post_id)
{
    _insert(UPDATE_POST_LIKES, [$post_id]);
}

############### RAW PDO FUNCTIONS ###############

function _select($query, $params = [])
{
    $dbh = connectToDatabase();
    $statement = $dbh->prepare($query);
    $statement->execute(trim_params($params));

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function _insert($query, $params)
{
    $dbh = connectToDatabase();
	$statement = $dbh->prepare($query);
	$statement->execute(trim_params($params));
}

############### MISC ###############

function trim_params($params)
{
    $trimmed_params = [];

    foreach($params as $param)
    {
        array_push($trimmed_params, trim($param));
    }

    return $trimmed_params;
}

?>