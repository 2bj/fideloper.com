<div class="container">
	<form method="post" action="/{{ $adminGroup }}/article">
		<div class="row">
			<div class="span12">
				<h1>New Article</h1>
			</div>
		</div><!-- end .row -->

		<div class="row">
			<div class="span9 article-editable">
				<!-- title -->
				<div class="control-group @if( isset($errors) && $errors->has('title') )error@endif">
					<label class="control-label" for="title">Title:</label>
					<div class="controls">
						<input type="text" id="title" name="title" placeholder="Title" value="@if( isset($input['title']) ){{ $input['title'] }}@endif">
						@if( isset($errors) && $errors->has('title') )
						<span class="help-inline">{{ $errors->first('title') }}</span>
						@endif
					</div>
				</div>

				<!-- url -->
				<div class="control-group @if( isset($errors) && $errors->has('url_title') )error@endif">
					<label class="control-label" for="url_title">URL:</label>
					<div class="controls">
						<input type="text" id="url_title" name="url_title" placeholder="URL" value="@if( isset($input['url_title']) ){{ $input['url_title'] }}@endif">
						@if( isset($errors) && $errors->has('url_title') )
						<span class="help-inline">{{ $errors->first('url_title') }}</span>
						@endif
					</div>
				</div>

				<!-- excerpt -->
				<div class="control-group @if( isset($errors) && $errors->has('content') )error@endif">

					<label class="control-label" for="excerpt">Excerpt:</label>
					<div class="controls">
						<textarea id="excerpt" name="excerpt" placeholder="Excerpt">@if( isset($input['excerpt']) ){{ $input['excerpt'] }}@endif</textarea>
						@if( isset($errors) && $errors->has('excerpt') )
						<span class="help-inline">{{ $errors->first('excerpt') }}</span>
						@endif
					</div>
				</div>

				<!-- content -->
				<div class="control-group @if( isset($errors) && $errors->has('content') )error@endif">
					<label class="control-label" for="content">Content:</label>
					<div class="controls">
						<textarea id="content" name="content" placeholder="Content">@if( isset($input['content']) ){{ $input['content'] }}@endif</textarea>
						@if( isset($errors) && $errors->has('content') )
						<span class="help-inline">{{ $errors->first('content') }}</span>
						@endif
					</div>
				</div>
			</div><!-- end .span9 -->

			<div class="span3">
				<!-- author -->
				<div class="control-group @if( isset($errors) && $errors->has('user_id') )error@endif">
					<label class="control-label" for="user_id">Author:</label>
					<div class="controls">
						<select name="user_id" id="user_id">
							@foreach ( $authors as $author )
							<option value="{{ $author->id }}" @if ( isset($input['user_id']) && $input['user_id'] == $author->id ) selected @endif>{{ $author->email }}</option>
							@endforeach
						</select>
						@if( isset($errors) && $errors->has('user_id') )
						<span class="help-inline">{{ $errors->first('user_id') }}</span>
						@endif
					</div>
				</div>

				<!-- status -->
				<div class="control-group @if( isset($errors) && $errors->has('status_id') )error@endif">
					<label class="control-label" for="status_id">Status:</label>
					<div class="controls">
						<select name="status_id" id="status_id">
							@foreach ( $statuses as $status )
							<option value="{{ $status->id }}" @if ( isset($input['status_id']) && $input['status_id'] == $status->id ) selected @endif>{{ $status->name }}</option>
							@endforeach
						</select>
						@if( isset($errors) && $errors->has('status_id') )
						<span class="help-inline">{{ $errors->first('status_id') }}</span>
						@endif
					</div>
				</div>

				<!-- created date -->
				<div class="control-group @if( isset($errors) && $errors->has('created_at') )error@endif">

					<label class="control-label" for="created_at">Created:</label>
					<div class="controls">
						<input type="text" id="created_at" name="created_at" placeholder="{{ date('m/d/Y H:i:s') }}" value="@if( isset($input['created_at']) ){{ $input['created_at'] }}@endif">
						@if( isset($errors) && $errors->has('created_at') )
						<span class="help-inline">{{ $errors->first('created_at') }}</span>
						@endif
					</div>
				</div>
			</div><!-- end .span3 -->
		</div><!-- end .row -->



		<button class="btn btn-large btn-primary" type="submit">Create</button>
      </form>
</div>