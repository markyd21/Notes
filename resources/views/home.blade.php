@extends('layouts.app')

@section('content')
	<div class="container">
	  <div class="jumbotron noteView">
		<div class="col-md-12">
			<span class="glyphicon glyphicon-resize-small col-md-1 col-lg-1" title="Hide Note"></span>
			<span class="glyphicon glyphicon-remove-circle col-md-1 col-lg-1" title="Delete Note"></span>
			<span class="glyphicon glyphicon-repeat col-md-1 col-lg-1" title="Restore Note"></span>
			<span class="glyphicon glyphicon-share col-md-1 col-lg-1" title="Share Note"></span>
			<span class="glyphicon glyphicon-pencil col-md-1 col-lg-1" title="Edit Note"></span>
		</div>
		<div class="note">
			<h1></h1>
			<h3></h3>
			<p class="lead"></p>
		</div>
		{{  Form::open(array('action'=>'NotesController@store', 'method' => 'post')) }}  
			<input type="hidden" id="id" name="id" value="">
			<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
				<label for="title" class="col-md-4 control-label">Note Title</label>
				<div class="col-md-12">
					<input id="title" type="title" class="form-control" name="title">
				</div>
			</div>

			<div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
				<label for="body" class="col-md-4 control-label">Note</label>
				<div class="col-md-12">
					<textarea id="body" class="form-control" name="body"></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn btn-primary">Save Note</button>
					<button type="button" class="btn btn-primary editNoteCancel">Cancel</button>
				</div>
			</div>
		 {{  Form::close() }} 
		<div id="shareNoteForm">
			<h3>Choose Friends to share this note with</h3>
		</div>
	  	  <div style="clear:both"></div>
	  </div>

	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a data-toggle="tab" href="#notes1">Your Notes</a></li>
		<li role="presentation"><a data-toggle="tab" href="#notes2">Notes shared with you</a></li>
		<li role="presentation" class="createNote"><a href="#">Create new note</a></li>
		<li role="presentation"><a data-toggle="tab" href="#notes3">Deleted Notes</a></li>
	</ul>
	<div class="tab-content">
	  <div id="notes1" class="tab-pane fade in active">
		<div class="row marketing list-group col-lg-12">
			<?php
				foreach ($myNotes as $myNote) {
					$noteHTML = "";
					$noteHTML .= '<div noteId = "'.$myNote->id.'" class="list-group-item noteContainer"><a href="#pageTop">';
					$noteHTML .= '<h4 class="list-group-item-heading">'.$myNote->title.'</h4></a>';
					$noteHTML .= '<p class="list-group-item-text">'.str_limit($myNote->body, 100).'</p>';
					$noteHTML .= '<span id="noteBodyHidden">'.$myNote->body.'</span>';
					$noteHTML .= '<span id="noteDateHidden">'.date_format($myNote->created_at, 'M d, Y').' @ '.date_format($myNote->created_at, 'h:i a').'</span>';
					$noteHTML .= '</div>';
					echo $noteHTML;
				}
			?>
		</div>
	  </div>
	  <div id="notes2" class="tab-pane fade">
			<?php
				foreach ($mySharedNotes as $mySharedNote) {
					$sharedHTML = "";
					$sharedHTML .= '<div noteId = "'.$mySharedNote->id.'" class="list-group-item noteContainer"><a href="#pageTop">';
					$sharedHTML .= '<h4 class="list-group-item-heading">'.$mySharedNote->title.'</h4></a>';
					$sharedHTML .= '<p class="list-group-item-text">'.str_limit($mySharedNote->body, 100).'</p>';
					$sharedHTML .= '<span id="noteBodyHidden">'.$mySharedNote->body.'</span>';
					$sharedHTML .= '<span id="noteDateHidden">'.date_format($mySharedNote->created_at, 'M d, Y').' @ '.date_format($mySharedNote->created_at, 'h:i a').'</span>';
					$sharedHTML .= '</div>';
					echo $sharedHTML;
				}
			?>
	  </div>
	  <div id="notes3" class="tab-pane fade">
			<?php
				foreach ($myDeletedNotes as $myDeletedNote) {
					$deletedHTML = "";
					$deletedHTML .= '<div noteId = "'.$myDeletedNote->id.'" class="list-group-item noteContainer"><a href="#pageTop">';
					$deletedHTML .= '<h4 class="list-group-item-heading">'.$myDeletedNote->title.'</h4></a>';
					$deletedHTML .= '<p class="list-group-item-text">'.str_limit($myDeletedNote->body, 100).'</p>';
					$deletedHTML .= '<span id="noteBodyHidden">'.$myDeletedNote->body.'</span>';
					$deletedHTML .= '<span id="noteDateHidden">'.date_format($myDeletedNote->created_at, 'M d, Y').' @ '.date_format($myDeletedNote->created_at, 'h:i a').'</span>';
					$deletedHTML .= '</div>';
					echo $deletedHTML;
				}
			?>
	  </div>
	</div>

	  <footer class="footer">
		<p></p>
	  </footer>

	</div> <!-- /container -->
@endsection
