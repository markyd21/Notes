<?php

namespace App\Http\Controllers;
use Auth;
use App\notes;
use App\shared_notes;
use Illuminate\Http\Request;
use App\Http\Requests;

class NotesController extends Controller
{ 

    public function index()
	{
		$userId = Auth::user()->id;
		$myNotes = Notes::where('user_id', $userId)
						->get();
		$myDeletedNotes = Notes::onlyTrashed()
						->where('user_id', $userId)
						->get();
		$mySharedNotes = Notes::join('shared_notes', 'shared_notes.note_id', '=', 'notes.id')
						->where('shared_notes.user', $userId)
						->get();				
        return view('home', ['myNotes'=>$myNotes, 'myDeletedNotes'=>$myDeletedNotes, 'mySharedNotes'=>$mySharedNotes]);
	}
	
	public function store(Request $request)
	{
		// Validate the request...
		$userId = Auth::user()->id;
		$id = "0";
		$id = $request->id;
		$notes = Notes::find($id);
		switch(true){
			case !$notes:
				$notes = new Notes;
		}
		$notes->title = $request->title;
		$notes->body = $request->body;
		$notes->user_id = $userId;
		$notes->save();
		return redirect()->route('notes_home');
	}

	public function remove(Request $request)
	{
		$userId = Auth::user()->id;
		$id = $request->id;
		$notes = Notes::find($id);
		$notes->delete();
	}
	
	public function restore(Request $request)
	{
		$userId = Auth::user()->id;
		$id = $request->id;
		$notes = Notes::withTrashed();
		$notes->where('id',$id);
		$notes->restore();
	}
	
	public function share(Request $request)
	{
		$userId = Auth::user()->id;
		$shared_notes = new shared_notes;
		$shared_notes->user = $request->userid;
		$shared_notes->note_id = $request->noteid;
		$shared_notes->save();
	}
}
