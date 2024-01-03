
$(document).ready(function() {
    $("#sound-player").jPlayer({
        cssSelectorAncestor: '#sound-container',
        swfPath: "{{ asset('libs/jplayer/') }}",
        supplied: "mp3,m4a,wav",
        wmode: "window",
        volume:  100,
        smoothPlayBar: true,
        keyEnabled: true
    });
});

function playSong(song, format) {
    $('.current-song').removeClass('current-song');
	$('.current-play').show();
	$('.current-play').removeClass('current-play');
	$('.current-seek').removeClass('current-seek');
	if(format == 'mp4') {
		format = 'm4a';
	}
	if(format == 'mp3') {
		$("#sound-player").jPlayer("setMedia",{mp3:song}).jPlayer("stop");
	} else if(format == 'm4a') {
		$("#sound-player").jPlayer("setMedia",{m4a:song}).jPlayer("stop");
	} else if(format == 'wav') {
		$("#sound-player").jPlayer("setMedia",{wav:song}).jPlayer("stop");
	}
}


function playerVolume() {
	// Delay the function for a second to get the latest style value
	setTimeout(function() {
		// Get the style attribute value
		var new_volume = $(".jp-volume-bar-value").attr("style");
		
		// Strip off the width text
		var new_volume = new_volume.replace("width: ", "");
		
		if(new_volume != "100%;") {
			// Remove everything after the first two characters 00
			var new_volume = new_volume.substring(0, 2).replace(".", "").replace("%", "");
		}
		
		if(new_volume.length == 1) {
			var new_volume = "0.0"+new_volume;
		} else if(new_volume.length == 2) {
			var new_volume = "0."+new_volume;
		} else {
			var new_volume = 1;
		}
		
		// Save the new volume value
		localStorage.setItem("volume", new_volume);
	}, 1);	
}


function startLoadingBar() {
	// only add progress bar if added yet.
	$("#loading-bar").show();
	$("#loading-bar").width((50 + Math.random() * 30) + "%");
}
function stopLoadingBar() {
	//End loading animation
	$("#loading-bar").width("101%").delay(200).fadeOut(400, function() {
		$(this).width("0");
	});
}
function pauseSong() {
	$("#sound-player").jPlayer('pause');
}

function repeatSong(type) {
	// Type 0: No repeat
	// Type 1: Repeat
	if(type == 1) {
		$('#repeat-song').html('1');
	} else {
		$('#repeat-song').html('0');
	}
}


$(document).on("keydown", function(key) {
    if(key.keyCode == 32) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            if($("#sound-player").data('jPlayer').status.paused) {
                $("#sound-player").jPlayer('play');
            } else {
                $("#sound-player").jPlayer('pause');
            }
        }
    }
    if(key.keyCode == 39) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            $('#next-button').click();
        }
    }
    if(key.keyCode == 37) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            $('#prev-button').click();
        }
    }
    if(key.keyCode == 77) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            if($('.jp-unmute').is(':hidden')) {
                $('.jp-mute').click();
            } else {
                $('.jp-unmute').click();
            }
        }
    }
    if(key.keyCode == 77) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            if($('.jp-unmute').is(':hidden')) {
                $('.jp-mute').click();
            } else {
                $('.jp-unmute').click();
            }
        }
    }
    if(key.keyCode == 82) {
        if($('input:focus, textarea:focus').length == 0) {
            // Prevent the key action
            key.preventDefault();
            if($('.jp-repeat-off').is(':hidden')) {
                $('.jp-repeat').click();
            } else {
                $('.jp-repeat-off').click();
            }
        }
    }
});