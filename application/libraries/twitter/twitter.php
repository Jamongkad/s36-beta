<?php
namespace Twitter;

class twitter
{
    protected $_screenName;
	
    public function __construct($screenName)
    {
        $this->_screenName = $screenName;
    }


    public function getMyTimeline($limit = 10, $formatLinks = TRUE)
    {
        $data = file_get_contents('http://twitter.com/statuses/user_timeline.json?screen_name=' . $this->_screenName . '&count=' . $limit);
        $twitts = json_decode($data);

        if ($formatLinks === TRUE)
        {
            $twitts = $this->_formatLinks($twitts);
        }

        return $twitts;
    }
	public function getRateLimit()
    {
        $data = file_get_contents('http://twitter.com/account/rate_limit_status.json');
        $twitts = json_decode($data);

        return $twitts;
    }


    public function getPublicTimeline($limit = 10, $formatLinks = TRUE)
    {
        $data = file_get_contents('http://twitter.com/statuses/public_timeline.json');
        $twitts = json_decode($data);

        if ($formatLinks === TRUE)
        {
            $twitts = $this->_formatLinks($twitts);
        }

        return $twitts;
    }


    public function getFriendsStatus($formatLinks = TRUE)
    {
        $data = file_get_contents('http://twitter.com/statuses/friends.json?screen_name=' . $this->_screenName);
        $status = json_decode($data);

        return $status;
    }


    public function getUserRelationship($targetScreenname)
    {
        $data = file_get_contents('http://twitter.com/friendships/show.json?source_screen_name=' . $this->_screenName . '&target_screen_name=' . $targetScreenname);
        $relationship = json_decode($data);

        return $relationship->relationship;
    }

    public function findTwitts($query, $formatLinks = TRUE)
    {
        $data = file_get_contents('http://search.twitter.com/search.json?q=' . urlencode($query));
        $twitts = json_decode($data);

        if ($formatLinks === TRUE)
        {
           $twitts = $this->_formatLinks($twitts->results);
        }
        else
        {
            $twitts = $twitts->results;
        }

        return $twitts;
    }


    public function getUserInformation($tweetname)
    {
        $data = file_get_contents('http://twitter.com/users/show.json?screen_name=' . $tweetname);
        $userInformation = json_decode($data);
		
        return $userInformation;
    }


    protected function _formatLinks($twitts)
    {
        for ($i = 0; $i < count($twitts); $i++)
        {
          
            $twitts[$i]->text = preg_replace('/((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i', '<a href="$1" target="_blank">$1</a>', $twitts[$i]->text);

          
            $twitts[$i]->text = preg_replace('/@([a-zA-Z-+_]+)/i', '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $twitts[$i]->text);

           
            $twitts[$i]->text = preg_replace('/#([a-zA-Z-+_]+)/i', '<a href="http://twitter.com/search?q=%23$1" target="_blank">#$1</a>', $twitts[$i]->text);
        }

        return $twitts;
    }
}

?>