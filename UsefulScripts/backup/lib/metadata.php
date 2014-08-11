<?php

function register_emoncms_feed($mysqli,$redis,$feed)
{
    // Check if feed exists in meta data:
    $result = $mysqli->query("SELECT id FROM feeds WHERE `id` = '".$feed->id."'");
    if (!$result->num_rows) 
    {
        echo "Create feed ".$feed->id."\n";
               
        $mysqli->query("INSERT INTO feeds (id,userid,name,tag,datatype,public,size,engine) VALUES ('".$feed->id."','".$feed->userid."','".$feed->name."','".$feed->tag."','".$feed->datatype."','".$feed->public."','".$feed->size."','".$feed->engine."')");

        $redis->hMSet("feed:$feed->id",array(
            'id'=>$feed->id,
            'userid'=>$feed->userid,
            'name'=>$feed->name,
            'datatype'=>$feed->datatype,
            'tag'=>$feed->tag,
            'public'=>$feed->public,
            'size'=>$feed->size,
            'engine'=>$feed->engine
        ));
    } else {
        // echo "feed exists ".$feed->id."\n";
    }
}

function reload_emoncms_feeds($mysqli,$redis,$userid)
{
    $result = $mysqli->query("SELECT id,userid,name,datatype,tag,public,size,engine FROM feeds WHERE `userid` = '$userid'");
    
    while ($row = $result->fetch_object())
    {
        $redis->sAdd("user:feeds:$userid", $row->id);
        $redis->hMSet("feed:$row->id",array(
        'id'=>$row->id,
        'userid'=>$row->userid,
        'name'=>$row->name,
        'datatype'=>$row->datatype,
        'tag'=>$row->tag,
        'public'=>$row->public,
        'size'=>$row->size,
        'engine'=>$row->engine
        ));
    }
}
