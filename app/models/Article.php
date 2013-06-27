<?php

class Article extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

    protected $fillable = array(
        'user_id',
        'status_id',
        'title',
        'url_title',
        'excerpt',
        'content',
    );

    public function tags()
    {
        return $this->belongsToMany('Tag', 'tags_articles', 'article_id', 'tag_id');
    }

    public function status()
    {
        return $this->belongsTo('Status');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}