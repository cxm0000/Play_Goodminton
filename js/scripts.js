$(document).ready(function (){
	//tab view
	$(function () {
	    var tabContainers = $('section.tabs > section');
	    
	    $('section.tabs ul.tabNavigation a').click(function () {
	        tabContainers.hide().filter(this.hash).show();
	        
	        $('section.tabs ul.tabNavigation a').removeClass('selected');
	        $(this).addClass('selected');
	        
	        return false;
	    }).filter(':first').click();
	});
	
	//ajaxforms
	var formOptions = { 
		type:		'post',
	    //target:     '#response', 
	    url:        'formSubmit.php',
	    success:    function(resp) {
	    	if(resp == 1001) {
	    		alert('Adding user failed, because same user has already exist!');
	    	} else {
	    		alert("New player added!");
	    		var obj = jQuery.parseJSON(resp);
	        	$("#allPlayers").append("<li id='"+obj.id+"'>"+obj.name+" -- <small>"+obj.email+"</small></li>");
	    	}
	    	
	    } 
	}; 
	
	
	$('#addPlayer').submit(function() { 
	        // inside event callbacks 'this' is the DOM element so we first 
	        // wrap it in a jQuery object and then invoke ajaxSubmit 
	        $(this).ajaxSubmit(formOptions); 
	 
	        // !!! Important !!! 
	        // always return false to prevent standard browser submit and page navigation 
	        return false; 
	});
	
	//add event form
	var formOptions2 = { 
		type:		'post',
	    //target:     '#response', 
	    url:        'formSubmit.php',
	    success:    function(resp) {
	    	if(resp !== false) {
	    		alert("New event added!");
	    		//var obj = jQuery.parseJSON(resp);
	        	//$("#allPlayers").append("<li id='"+obj.id+"'>"+obj.name+"</li>");
	    	}
	    	
	    } 
	}; 
	
	
	$('#addEvent').submit(function() { 
	        // inside event callbacks 'this' is the DOM element so we first 
	        // wrap it in a jQuery object and then invoke ajaxSubmit 
	        $(this).ajaxSubmit(formOptions2); 
	 
	        // !!! Important !!! 
	        // always return false to prevent standard browser submit and page navigation 
	        return false; 
	});


	$("#allPlayers").sortable({
		connectWith: ['#toInvite']
	});
	$("#toInvite").sortable({
		connectWith: ['#allPlayers'],
	
		receive: function(event, ui) {}

	}); 

	$('#inviteBtn').click(function() {
		var jsonObj = [];

		//add userId
		$("#toInvite").children().each(function(idx, item) {
    		jsonObj.push({id: $(this).attr('id')});

		});

		//add event info
		var eventInfo = [];
		eventInfo=[{
			name: $('#event_name').val(),
			time: $('#time').val(),
			location: $('#place').val(),
			extrainfo: $('#info').val(),
		}];

		$.ajax({
			type: "POST",
			url: "ajax.php",
			dataType: "json",
			data: {action:'add', ids: jsonObj, event: eventInfo},
			success: function(resp){
				console.log(resp);
				if(resp == 200) {
					alert("All friends have been emailed!");
				} else {
					alert("Sorry, there is something wrong with the site now. Please try later.");
				}
			}
		});
	});
	
	//js scripts for mobile devices
	$("#allPlayers li").mobiledraganddrop({
		"classmodifier": "mobiledraganddrop",
		"targets": "#toInvite",
    	"status": "",
    	"selectedclass": "selected",
		"activeclass": "active"
	});
	
});