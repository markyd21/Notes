$(document).ready(function(){
	var firstNoteObj = getFirstNoteIdInList();
	viewNote(firstNoteObj);
});

$(document).on('click', '#notes1 .noteContainer', function(){
	viewNote($(this));	
});

$(document).on('click', '#notes2 .noteContainer', function(){
	viewSharedNote($(this));	
});

$(document).on('click', '#notes3 .noteContainer', function(){
	viewDeletedNote($(this));	
});

$(document).on('click', '.noteView .glyphicon-resize-small', function(){
	hideNoteView();	
});

$(document).on('click', '.glyphicon-pencil', function(){
	editNote();
});

$(document).on('click','.editNoteCancel', function(e){
	cancelNoteEdit();
});

$(document).on('click','.createNote', function(e){
	createNote();
});

$(document).on('click','.glyphicon-remove-circle', function(e){
	deleteNote();
});

$(document).on('click','.glyphicon-repeat', function(e){
	restoreNote();
});

$(document).on('click','.glyphicon-share', function(e){
	getFriendsToShareNoteWith($(this).attr('noteid'));
	showShareNotesForm();
});

$(document).on('click','#shareNoteSubmit', function(e){
	getnoteShareData();
});

function viewSharedNote(thisObj)
{
	var noteObj = getNoteData(thisObj);
	setNoteData(noteObj);
	hideGlyphIcons();
	showNoteView();
}

function getnoteShareData()
{
	$('#shareNoteForm div input:checked').each(function(){
		dataObj = {};
		dataObj.noteid = $(this).attr('noteid');
		dataObj.userid = $(this).attr('userid');
		sendNoteShareData(dataObj);
	});
	window.location.href =  base_url+'/home';
}

function sendNoteShareData(dataObj)
{
	$.ajax({
		data:dataObj,
		type:'POST',
		headers:{
			'X-CSRF-Token': $('input[name="_token"]').val()
		},	
		url:'./share_note',
		dataType:'JSON',
		success:function(data){
			
		}
	});
}

function getFriendsToShareNoteWith(noteid)
{
	$.ajax({
		type:'POST',
		headers:{
			'X-CSRF-Token': $('input[name="_token"]').val()
		},	
		url:'./get_friends',
		dataType:'JSON',
		success:function(data){
			buildShareNotesForm(data, noteid);
		}
	});
}

function showShareNotesForm(){
	$('#shareNoteForm').show();
	hideGlyphIcons();
	hideNote();
}


function buildShareNotesForm(dataObj, noteid)
{
	var htmlStr = '';
	$.each(dataObj, function(k,v){
		htmlStr += '<div><input type="checkbox" noteid="'+noteid+'" userid="'+v["friend_id"]+'">'+v["name"]+'</div>';
	});
	htmlStr += '<input type="button" id="shareNoteSubmit" value="Share Note" />';
	$('#shareNoteForm').append(htmlStr);
}

function getFirstNoteIdInList()
{
	return $('#notes1 .noteContainer:first');
}

function getNoteData(thisObj)
{
	var noteObj = {};
	noteObj.id = thisObj.attr('noteid');
	noteObj.title = thisObj.find('h4').text();
	noteObj.date = thisObj.find('span#noteDateHidden').text();
	noteObj.body = thisObj.find('span#noteBodyHidden').text();
	return noteObj;
}

function setNoteData(noteObj)
{
	$('.note h1').text(noteObj.title);
	$('.note h3').text(noteObj.date);
	$('.note p').text(noteObj.body);
	$('.noteView .glyphicon-pencil').attr('noteid', noteObj.id);
	$('.noteView .glyphicon-remove-circle').attr('noteid', noteObj.id);
	$('.noteView .glyphicon-share').attr('noteid', noteObj.id);
}

function createNote()
{
	showNoteView();
	hideNote();
	hideGlyphIcons();
	clearNoteEditForm();
	showNoteEditForm();
}

function viewDeletedNote(thisObj)
{
	var noteObj = getNoteData(thisObj);
	setNoteData(noteObj);
	$('.noteView .glyphicon-repeat').show();
	$('.noteView .glyphicon-remove-circle').hide();
	showNoteView();
}

function viewNote(thisObj)
{
	var noteObj = getNoteData(thisObj);
	setNoteData(noteObj);
	showGlyphIcons();
	showNoteView();
}

function editNote()
{
	hideNote();
	var noteObj = getEditNoteFormData();
	setEditNoteFormData(noteObj);
	hideGlyphIcons();
	showNoteEditForm();
}

function deleteNote(thisObj)
{
	var noteObj = getEditNoteFormData();
	sendDeleteData(noteObj);
}

function restoreNote(thisObj)
{
	var noteObj = getEditNoteFormData();
	sendRestoreData(noteObj);
}

function sendDeleteData(noteObj)
{
	$.ajax({
		type:'POST',
		headers:{
        'X-CSRF-Token': $('input[name="_token"]').val()
		},	
		url: base_url+'/home/deleteNote',
		async:false,
		data:noteObj,
		success:function(){
			 window.location.href =  base_url+'/home';
		}
	});
}

function sendRestoreData(noteObj)
{
	$.ajax({
		type:'POST',
		headers:{
        'X-CSRF-Token': $('input[name="_token"]').val()
		},	
		url:  base_url+'/home/restoreNote',
		async:false,
		data:noteObj,
		success:function(){
			 window.location.href = base_url+'/home';
		}
	});
}

function getEditNoteFormData()
{
	var noteId = $('.noteView .glyphicon-pencil').attr('noteid');
	var thisObj = $('.noteContainer[noteid = "'+noteId+'"]');
	var noteObj = getNoteData(thisObj);
	return noteObj;
}

function setEditNoteFormData(noteObj)
{
	$('.noteView form #id').val(noteObj.id);
	$('.noteView form #title').val(noteObj.title);
	$('.noteView form #body').val(noteObj.body);
}

function showNoteView()
{
	$('.noteView').slideDown();
}

function hideNoteView()
{
	hideNoteEditForm();
	showNote();
	$('.noteView').slideUp();
}

function showNote()
{
	$('.noteView .note').show();
}

function hideNote()
{
	$('.noteView .note').hide();
}

function showNoteEditForm()
{
	$('.noteView form').show();
}

function clearNoteEditForm()
{
	$('.noteView form')[0].reset();
}

function hideNoteEditForm()
{
	$('.noteView form').hide();
}

function showGlyphIcons()
{
	$('.noteView .glyphicon').show();
	$('.noteView .glyphicon-repeat').hide();
}

function hideGlyphIcons()
{
	$('.noteView .glyphicon').hide();
}

function cancelNoteEdit(){
	hideNoteEditForm();
	var firstNoteObj = getFirstNoteIdInList();
	viewNote(firstNoteObj);
	showNote();
}
