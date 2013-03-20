<?php

class ContentController extends BaseController {

	protected $layout = 'layouts.site';

	protected $article;

	public function __construct(Fideloper\Storage\Article\ArticleInterface $article)
	{
		$this->article = $article;
	}

	/**
	* Display listing of latest articles
	*/
	public function index()
	{	
		$articles = $this->article->getPaginated();

		$this->layout->content = View::make('content.home')->with('articles', $articles);
	}

	/**
	* Display specific article
	*/
	public function article($slug)
	{
		$article = $this->article->getBySlug($slug);
		$recents = $this->article->getRecent();

		if( !$article )
		{
			App::abort(404);
		}

		// Head data
		$tags = [];
		foreach( $article->tags as $tag )
		{
			$tags[] = $tag->name;
		}

		$head = App::make('headdata');
		$head->add('title', $article->title.' | Fideloper');
		$head->add('keywords', implode(',', $tags));

		// Output Article
		$this->layout->content = View::make('content.article', [
			'article' => $article,
			'recents' => $recents
		]);
	}

	/**
	* Display articles under a tag
	*/
	public function tag($tag)
	{
		$articles = $this->article->getByTag($tag);

		if( count($articles) === 0 )
		{
			App::abort(404);
		}

		// Head data
		$head = App::make('headdata');
		$head->add('title', $tag . ' | Fideloper');

		// Output Articles
		$this->layout->content = View::make('content.tags', [
			'articles' => $articles,
			'tag' => $tag
		]);
	}

	/**
	* Display articles in a time range
	*/
	public function archive($date)
	{
		return $date;
	}

	public function feed()
	{
		$feed = new Suin\RSSWriter\Feed();
		$channel = new Suin\RSSWriter\Channel();

		$channel
		    ->title( "Fideloper" )
		    ->description( "Lead dev @digitalsurgeons. I do LAMP, Laravel, Nodejs, Python, and lots of server stuff." )
		    ->url( 'http://fideloper.com' )
		    ->appendTo( $feed );

		$articles = $this->article->getRecent(30);

		foreach( $articles as $article )
		{
			$item = new Suin\RSSWriter\Item();

			$item
			    ->title( $article->title )
			    ->description( $article->excerpt )
			    ->url( 'http://fideloper.com/'.$article->url_title )
			    ->appendTo( $channel );
		}

		return Response::make($feed, 200, ['Content-Type' => 'application/xml']);

	}

}