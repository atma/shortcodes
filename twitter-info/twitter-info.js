jQuery(document).ready(function($) {
	var time = 250;
	var hideDelay = 500;
	var hideDelayTimer = null;
	var beingShown = false;
	var shown = false;
	var twitname, twitinfo_html;

	var twitinfo_popup = document.createElement("div");
	document.body.appendChild(twitinfo_popup);
	var $twitinfo_popup = $(twitinfo_popup);
	$twitinfo_popup.addClass("twitinfo-popup").hide();

	var twitinfo_content = document.createElement("div");
	twitinfo_popup.appendChild(twitinfo_content);
	var $twitinfo_content = $(twitinfo_content);
	$twitinfo_content.addClass("twitinfo-content");

	$('a.twitter-info, div.twitinfo-popup').bind('mouseenter',function () {
		var offset = $(this).offset();
		var top = offset.top + 18;
		var left = offset.left - 100;

        if (hideDelayTimer) clearTimeout(hideDelayTimer);
        if (beingShown || shown) {
            // don't trigger the animation again
            return;
        } else {
			beingShown = true;
			twitname = $(this).attr('title');

			$(this).css("position","relative");
			$twitinfo_content.html('<div class="twitinfo-loading">Loading...</div>');
			var url = 'http://twitter.com/users/show/' + twitname + '.json?callback=?';
			$.getJSON(url, function(info) {
				twitinfo_html = '<table><tr>\n';
				twitinfo_html += '<td rowspan=2 class="leftcol"><img src="'+ info.profile_image_url +'" alt="'+ info.name +'" />\n';
				twitinfo_html += '<div class="twitter-follow"><a href="http://twitter.com/'+ info.screen_name +'" title="Follow me">Follow</a></div></td>\n';
				twitinfo_html += '<td>\n';
				twitinfo_html += '<ul class="twitter-vcard">\n';
				twitinfo_html += '<li class="twitter-label"><span>Name:</span> '+ info.name +'</li>\n';
				if (info.location != '') twitinfo_html += '<li class="twitter-label"><span>Location:</span> '+ info.location +'</li>\n';
				if (info.url != null) twitinfo_html += '<li class="twitter-label"><span>Web:</span> <a href="'+ info.url +'" target="_blank">'+ info.url +'</a></li>\n';
				if (info.description != '') twitinfo_html += '<li class="twitter-bio"><span>Bio:</span> '+ info.description +'</li>\n';
				twitinfo_html += '</ul>\n';

				twitinfo_html += '</td></tr>\n';
				twitinfo_html += '<tr><td>\n';

				twitinfo_html += '<div class="twitinfo-stats">';
				twitinfo_html += '<span class="twitinfo-stats-following"><em>'+ info.friends_count +'</em><a href="http://twitter.com/'+ info.screen_name +'/friends" target="_blank">following</a></span>';
				twitinfo_html += '<span class="twitinfo-stats-followers"><em>'+ info.followers_count +'</em><a href="http://twitter.com/'+ info.screen_name +'/followers" target="_blank">followers</a></span>';
				twitinfo_html += '<span class="twitinfo-stats-updates"><em>'+ info.statuses_count +'</em><a href="http://twitter.com/'+ info.screen_name +'" target="_blank">updates</a></span>';
				twitinfo_html += '</div>';

				twitinfo_html += '</td></tr>\n';
				twitinfo_html += '<tr><td colspan=2><span class="twitter-status"><strong>Current status:</strong><br />'+ info.status.text +'</span>\n';
				twitinfo_html += '<span class="twitinfo-meta">Submitted '+ info.created_at.substr(0,19) +' from '+ info.status.source +'<span></td>\n';
				twitinfo_html += '</tr></table>\n';
				$twitinfo_content.html(twitinfo_html);
	        });

            $twitinfo_popup.css({
                display: "block",
				position: "absolute",
				top: top + "px",
				left: left + "px",
				'z-index': 999
            }).fadeIn('slow', function() {
                beingShown = false;
                shown = true;
            });

		}
		return false;
	}).bind('mouseleave',function () {
        if (hideDelayTimer) clearTimeout(hideDelayTimer);
        hideDelayTimer = setTimeout(function () {
            hideDelayTimer = null;
			$twitinfo_popup.fadeOut('fast', function() {
                shown = false;
				$twitinfo_content.html('');

            });

        }, hideDelay);
        return false;
	});

});
