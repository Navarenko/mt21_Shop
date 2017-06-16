var tag = document.createElement('script');
		tag.src = 'https://www.youtube.com/player_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var tv,
		playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
var tv2,
		playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
var vid = [
			//{'videoId': 'TheFr7Nl-zY', 'startSeconds': 0, 'endSeconds': 30, 'suggestedQuality': 'hd720'} //stars
            {'videoId': 'GFe9FGGKlVM', 'startSeconds': 0, 'endSeconds': 22, 'suggestedQuality': '360'} //spring
		],
		randomvid = Math.floor(Math.random() * (vid.length - 1 + 1));
var vid2 = [
			{'videoId': 'Yqrfbd85Fi8', 'startSeconds': 5, 'endSeconds': 15, 'suggestedQuality': 'hd720'} //kamin
		],
		randomvid = Math.floor(Math.random() * (vid2.length - 1 + 1));

function onYouTubePlayerAPIReady(){
  tv = new YT.Player('tv', {events: {'onReady': onPlayerReady, 'onStateChange': onPlayerStateChange}, playerVars: playerDefaults});
  tv2 = new YT.Player('tv2', {events: {'onReady': onPlayerReady, 'onStateChange': onPlayerStateChange}, playerVars: playerDefaults});
}

function onPlayerReady(){
  tv.loadVideoById(vid[randomvid]);
  tv.mute();
	tv2.loadVideoById(vid2[randomvid]);
    tv2.mute();
}

function onPlayerStateChange(e) {
  if (e.data === 1){
    $('#tv').addClass('active');
	$('#tv2').addClass('active');
  } else if (e.data === 0){
    tv.seekTo(vid[randomvid].startSeconds)
	tv2.seekTo(vid2[randomvid].startSeconds)
  }
}

function vidRescale(){
  var w = $(window).width()+200,
    h = $(window).height()+200;

  if (w/h > 16/9){
    tv.setSize(w, w/16*9);
    $('.tv .screen').css({'left': '-120px'});
	tv2.setSize(w, w/16*9);
    $('.tv2 .screen').css({'left': '-120px'});
  } else {
    tv.setSize(h/9*16, h);
    $('.tv .screen').css({'left': -($('.tv .screen').outerWidth()-w)/1.5});
	tv2.setSize(h/9*16, h);
    $('.tv2 .screen').css({'left': -($('.tv2 .screen').outerWidth()-w)/1.5});
  }
}

$(window).on('load resize', function(){
  vidRescale();
});

$('.hi span').on('click', function(){
  $('#tv').toggleClass('mute');
	$('#tv2').toggleClass('mute');

  if($('#tv').hasClass('mute')){
    tv.mute();
  } else {
    tv.unMute();
  }

	if($('#tv2').hasClass('mute')){
    tv2.mute();
  } else {
    tv2.unMute();
  }
});