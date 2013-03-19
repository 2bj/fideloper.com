<?php

class ArticleController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @todo   Pagination
	 * @return Response
	 */
	public function index()
	{
		$articles = Article::with('user')->with('status')->orderBy('created_at', 'desc')->get();

		return View::make('layouts.admin')
			->with('body_class', 'admin article')
			->nest('nav', 'layouts.admin.nav', ['adminGroup' => Config::get('admin.group')])
			->nest('content', 'admin.articles', [
				'articles' => $articles,
				'adminGroup' => Config::get('admin.group'),
			]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$authors = User::all();
		$statuses = Status::all();

		return View::make('layouts.admin')
			->with('body_class', 'admin article create')
			->nest('nav', 'layouts.admin.nav', ['adminGroup' => Config::get('admin.group')])
			->nest('content', 'admin.articles.create', [
				'input' => Session::getOldInput(),
				'authors' => $authors,
				'statuses' => $statuses,
				'adminGroup' => Config::get('admin.group'),
			]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @todo   Validation, Filter Markdown
	 * @return Response
	 */
	public function store()
	{
		// Validation plz, kthnx
		$data = array(
			'user_id' => Input::get('user_id'),
			'status_id' => Input::get('status_id'),
			'title' => Input::get('title'),
			'url_title' => Input::get('url_title'),
			'excerpt' => Input::get('excerpt'),
			'content' => Input::get('content'),
		);

		$article = Article::create( $data );

		$tag = new Tag;
		$tags = $tag->tagsFromString( Input::get('tags') );

		if( count($tags) )
		{
			$tag->setTagsForArticle($article->id, $tags);
		}

		return Redirect::to(Config::get('admin.group').'/article');
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		// In context of admin area, we go to edit
		return Redirect::to(Config::get('admin.group').'/article/'.$id.'/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$article = Article::with('tags')->find($id);
		$authors = User::all();
		$statuses = Status::all();

		$tags = [];
		foreach( $article->tags as $tag )
		{
			$tags[] = $tag->name;
		}

		if ( is_object($article) )
		{
			return View::make('layouts.admin')
				->with('body_class', 'admin article edit')
				->nest('nav', 'layouts.admin.nav', ['adminGroup' => Config::get('admin.group')])
				->nest('content', 'admin.articles.edit', [
					'article' => $article,
					'article_tags' => $tags,
					'article_tags_formatted' => implode(', ', $tags),
					'authors' => $authors,
					'statuses' => $statuses,
					'adminGroup' => Config::get('admin.group'),
				]);
		}
		return Redirect::to(Config::get('admin.group').'/article');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @todo   Validation, Filter Markdown
	 * @return Response
	 */
	public function update($id)
	{
		$article = Article::find($id);

		$article->user_id = Input::get('user_id');
		$article->status_id = Input::get('status_id');
		$article->title = Input::get('title');
		$article->url_title = Input::get('url_title');
		$article->excerpt = Input::get('excerpt');
		$article->content = Input::get('content');

		$article->save();

		$tag = new Tag;
		$tags = $tag->tagsFromString( Input::get('tags') );

		if( count($tags) )
		{
			$tag->setTagsForArticle($id, $tags);
		}

		return Redirect::to(Config::get('admin.group').'/article/'.$id.'/edit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);
		$deleted = Status::where('name', 'Deleted')->get();

		$article->status = $deleted->id;
		$article->save();

		return Redirect::to(Config::get('admin.group').'/article');
	}

}