@extends('layouts.site')

@section('content')
<article class="sixteen columns post single cookbook">
  <div class="row">
    @if( $status === 'success' )
    <div class="success alert">
        <p style="padding-top:6px; margin-bottom:6px;">Thanks! Feel free to add more ideas.</p>
    </div>
    @elseif( $status === 'error' )
    <div class="danger alert">
        <ul style="padding-top:6px;">
            @foreach($errors->get('name') as $error)
            <li>{{ $error }}</li>
            @endforeach
            @foreach($errors->get('description') as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="content">
        <h2 class="title">What common problems would you like to see professional solutions to?</h2>
        <p>I'm starting a project which will explain how to accomplish <em>common</em> coding problems in <code>Laravel 4</code> such as:</p>
        <ol>
            <li>Gracefully Handling Errors</li>
            <li>Handling Forms and Validation</li>
            <li>Setting up Continuous Integration</li>
            <li>Setting up a Server for Laravel</li>
            <li>...and more</li>
        </ol>
        <form action="/laravel-cookbook" method="post" style="margin-top:40px;">
            <p>To better gauge what Laravel users are curious about, I'd like to ask you:</p>
            <h5 for="descr" style="margin-bottom:10px;"><strong>What common challenges would you like to see handled in a <code>maintainable</code>, <code>professional way</code> in Laravel 4?</strong></h5>
            <ul class="nine columns" style="margin-left:0;">
                <li class="field">
                    <input type="text" class="input" name="name" placeholder="Your name or @twitter" maxlength="255" value="{{ Input::old('name') }}" />
                </li>
                <li class="field">
                    <textarea maxlength="255" rows="4" class="input textarea" id="descr" name="description" placeholder="Briefly describe the coding challenge">{{ Input::old('description') }}</textarea>
                    <p class="small" style="font-size:12px;"><em>All fields required. Limit 255 characters. Consider using Markdown.</em></p>
                </li>
                <li>
                    <div class="medium primary btn icon-right entypo icon-camera"><input type="submit" value="Submit"></div>
                </li>
            </ul>
        </form>
    </div><!-- end content -->
  </div>
</article><!-- end article -->
@stop