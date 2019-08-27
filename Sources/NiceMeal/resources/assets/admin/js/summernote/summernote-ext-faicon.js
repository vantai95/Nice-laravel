(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}(function ($) {

  // fontawesome icon picker plugin
  $.extend($.summernote.plugins, {
    /**
     * @param {Object} context - context object has status of editor.
     */
    'faicon': function (context) {
      var self = this;
      var ui = $.summernote.ui;
			var options = context.options;

			// font-awesome: version 4.7.0; removed aliases
			var fa_icons = {"500px":"\uf26e","address-book":"\uf2b9","address-book-o":"\uf2ba","address-card":"\uf2bb","address-card-o":"\uf2bc","adjust":"\uf042","adn":"\uf170","align-center":"\uf037","align-justify":"\uf039","align-left":"\uf036","align-right":"\uf038","amazon":"\uf270","ambulance":"\uf0f9","american-sign-language-interpreting":"\uf2a3","anchor":"\uf13d","android":"\uf17b","angellist":"\uf209","angle-double-down":"\uf103","angle-double-left":"\uf100","angle-double-right":"\uf101","angle-double-up":"\uf102","angle-down":"\uf107","angle-left":"\uf104","angle-right":"\uf105","angle-up":"\uf106","apple":"\uf179","archive":"\uf187","area-chart":"\uf1fe","arrow-circle-down":"\uf0ab","arrow-circle-left":"\uf0a8","arrow-circle-o-down":"\uf01a","arrow-circle-o-left":"\uf190","arrow-circle-o-right":"\uf18e","arrow-circle-o-up":"\uf01b","arrow-circle-right":"\uf0a9","arrow-circle-up":"\uf0aa","arrow-down":"\uf063","arrow-left":"\uf060","arrow-right":"\uf061","arrow-up":"\uf062","arrows":"\uf047","arrows-alt":"\uf0b2","arrows-h":"\uf07e","arrows-v":"\uf07d","assistive-listening-systems":"\uf2a2","asterisk":"\uf069","at":"\uf1fa","audio-description":"\uf29e","backward":"\uf04a","balance-scale":"\uf24e","ban":"\uf05e","bandcamp":"\uf2d5","bar-chart":"\uf080","barcode":"\uf02a","bars":"\uf0c9","bath":"\uf2cd","battery-empty":"\uf244","battery-full":"\uf240","battery-half":"\uf242","battery-quarter":"\uf243","battery-three-quarters":"\uf241","bed":"\uf236","beer":"\uf0fc","behance":"\uf1b4","behance-square":"\uf1b5","bell":"\uf0f3","bell-o":"\uf0a2","bell-slash":"\uf1f6","bell-slash-o":"\uf1f7","bicycle":"\uf206","binoculars":"\uf1e5","birthday-cake":"\uf1fd","bitbucket":"\uf171","bitbucket-square":"\uf172","black-tie":"\uf27e","blind":"\uf29d","bluetooth":"\uf293","bluetooth-b":"\uf294","bold":"\uf032","bolt":"\uf0e7","bomb":"\uf1e2","book":"\uf02d","bookmark":"\uf02e","bookmark-o":"\uf097","braille":"\uf2a1","briefcase":"\uf0b1","btc":"\uf15a","bug":"\uf188","building":"\uf1ad","building-o":"\uf0f7","bullhorn":"\uf0a1","bullseye":"\uf140","bus":"\uf207","buysellads":"\uf20d","calculator":"\uf1ec","calendar":"\uf073","calendar-check-o":"\uf274","calendar-minus-o":"\uf272","calendar-o":"\uf133","calendar-plus-o":"\uf271","calendar-times-o":"\uf273","camera":"\uf030","camera-retro":"\uf083","car":"\uf1b9","caret-down":"\uf0d7","caret-left":"\uf0d9","caret-right":"\uf0da","caret-square-o-down":"\uf150","caret-square-o-left":"\uf191","caret-square-o-right":"\uf152","caret-square-o-up":"\uf151","caret-up":"\uf0d8","cart-arrow-down":"\uf218","cart-plus":"\uf217","cc":"\uf20a","cc-amex":"\uf1f3","cc-diners-club":"\uf24c","cc-discover":"\uf1f2","cc-jcb":"\uf24b","cc-mastercard":"\uf1f1","cc-paypal":"\uf1f4","cc-stripe":"\uf1f5","cc-visa":"\uf1f0","certificate":"\uf0a3","chain-broken":"\uf127","check":"\uf00c","check-circle":"\uf058","check-circle-o":"\uf05d","check-square":"\uf14a","check-square-o":"\uf046","chevron-circle-down":"\uf13a","chevron-circle-left":"\uf137","chevron-circle-right":"\uf138","chevron-circle-up":"\uf139","chevron-down":"\uf078","chevron-left":"\uf053","chevron-right":"\uf054","chevron-up":"\uf077","child":"\uf1ae","chrome":"\uf268","circle":"\uf111","circle-o":"\uf10c","circle-o-notch":"\uf1ce","circle-thin":"\uf1db","clipboard":"\uf0ea","clock-o":"\uf017","clone":"\uf24d","cloud":"\uf0c2","cloud-download":"\uf0ed","cloud-upload":"\uf0ee","code":"\uf121","code-fork":"\uf126","codepen":"\uf1cb","codiepie":"\uf284","coffee":"\uf0f4","cog":"\uf013","cogs":"\uf085","columns":"\uf0db","comment":"\uf075","comment-o":"\uf0e5","commenting":"\uf27a","commenting-o":"\uf27b","comments":"\uf086","comments-o":"\uf0e6","compass":"\uf14e","compress":"\uf066","connectdevelop":"\uf20e","contao":"\uf26d","copyright":"\uf1f9","creative-commons":"\uf25e","credit-card":"\uf09d","credit-card-alt":"\uf283","crop":"\uf125","crosshairs":"\uf05b","css3":"\uf13c","cube":"\uf1b2","cubes":"\uf1b3","cutlery":"\uf0f5","dashcube":"\uf210","database":"\uf1c0","deaf":"\uf2a4","delicious":"\uf1a5","desktop":"\uf108","deviantart":"\uf1bd","diamond":"\uf219","digg":"\uf1a6","dot-circle-o":"\uf192","download":"\uf019","dribbble":"\uf17d","dropbox":"\uf16b","drupal":"\uf1a9","edge":"\uf282","eercast":"\uf2da","eject":"\uf052","ellipsis-h":"\uf141","ellipsis-v":"\uf142","empire":"\uf1d1","envelope":"\uf0e0","envelope-o":"\uf003","envelope-open":"\uf2b6","envelope-open-o":"\uf2b7","envelope-square":"\uf199","envira":"\uf299","eraser":"\uf12d","etsy":"\uf2d7","eur":"\uf153","exchange":"\uf0ec","exclamation":"\uf12a","exclamation-circle":"\uf06a","exclamation-triangle":"\uf071","expand":"\uf065","expeditedssl":"\uf23e","external-link":"\uf08e","external-link-square":"\uf14c","eye":"\uf06e","eye-slash":"\uf070","eyedropper":"\uf1fb","facebook":"\uf09a","facebook-official":"\uf230","facebook-square":"\uf082","fast-backward":"\uf049","fast-forward":"\uf050","fax":"\uf1ac","female":"\uf182","fighter-jet":"\uf0fb","file":"\uf15b","file-archive-o":"\uf1c6","file-audio-o":"\uf1c7","file-code-o":"\uf1c9","file-excel-o":"\uf1c3","file-image-o":"\uf1c5","file-o":"\uf016","file-pdf-o":"\uf1c1","file-powerpoint-o":"\uf1c4","file-text":"\uf15c","file-text-o":"\uf0f6","file-video-o":"\uf1c8","file-word-o":"\uf1c2","files-o":"\uf0c5","film":"\uf008","filter":"\uf0b0","fire":"\uf06d","fire-extinguisher":"\uf134","firefox":"\uf269","first-order":"\uf2b0","flag":"\uf024","flag-checkered":"\uf11e","flag-o":"\uf11d","flask":"\uf0c3","flickr":"\uf16e","floppy-o":"\uf0c7","folder":"\uf07b","folder-o":"\uf114","folder-open":"\uf07c","folder-open-o":"\uf115","font":"\uf031","font-awesome":"\uf2b4","fonticons":"\uf280","fort-awesome":"\uf286","forumbee":"\uf211","forward":"\uf04e","foursquare":"\uf180","free-code-camp":"\uf2c5","frown-o":"\uf119","futbol-o":"\uf1e3","gamepad":"\uf11b","gavel":"\uf0e3","gbp":"\uf154","genderless":"\uf22d","get-pocket":"\uf265","gg":"\uf260","gg-circle":"\uf261","gift":"\uf06b","git":"\uf1d3","git-square":"\uf1d2","github":"\uf09b","github-alt":"\uf113","github-square":"\uf092","gitlab":"\uf296","glass":"\uf000","glide":"\uf2a5","glide-g":"\uf2a6","globe":"\uf0ac","google":"\uf1a0","google-plus":"\uf0d5","google-plus-official":"\uf2b3","google-plus-square":"\uf0d4","google-wallet":"\uf1ee","graduation-cap":"\uf19d","gratipay":"\uf184","grav":"\uf2d6","h-square":"\uf0fd","hacker-news":"\uf1d4","hand-lizard-o":"\uf258","hand-o-down":"\uf0a7","hand-o-left":"\uf0a5","hand-o-right":"\uf0a4","hand-o-up":"\uf0a6","hand-paper-o":"\uf256","hand-peace-o":"\uf25b","hand-pointer-o":"\uf25a","hand-rock-o":"\uf255","hand-scissors-o":"\uf257","hand-spock-o":"\uf259","handshake-o":"\uf2b5","hashtag":"\uf292","hdd-o":"\uf0a0","header":"\uf1dc","headphones":"\uf025","heart":"\uf004","heart-o":"\uf08a","heartbeat":"\uf21e","history":"\uf1da","home":"\uf015","hospital-o":"\uf0f8","hourglass":"\uf254","hourglass-end":"\uf253","hourglass-half":"\uf252","hourglass-o":"\uf250","hourglass-start":"\uf251","houzz":"\uf27c","html5":"\uf13b","i-cursor":"\uf246","id-badge":"\uf2c1","id-card":"\uf2c2","id-card-o":"\uf2c3","ils":"\uf20b","imdb":"\uf2d8","inbox":"\uf01c","indent":"\uf03c","industry":"\uf275","info":"\uf129","info-circle":"\uf05a","inr":"\uf156","instagram":"\uf16d","internet-explorer":"\uf26b","ioxhost":"\uf208","italic":"\uf033","joomla":"\uf1aa","jpy":"\uf157","jsfiddle":"\uf1cc","key":"\uf084","keyboard-o":"\uf11c","krw":"\uf159","language":"\uf1ab","laptop":"\uf109","lastfm":"\uf202","lastfm-square":"\uf203","leaf":"\uf06c","leanpub":"\uf212","lemon-o":"\uf094","level-down":"\uf149","level-up":"\uf148","life-ring":"\uf1cd","lightbulb-o":"\uf0eb","line-chart":"\uf201","link":"\uf0c1","linkedin":"\uf0e1","linkedin-square":"\uf08c","linode":"\uf2b8","linux":"\uf17c","list":"\uf03a","list-alt":"\uf022","list-ol":"\uf0cb","list-ul":"\uf0ca","location-arrow":"\uf124","lock":"\uf023","long-arrow-down":"\uf175","long-arrow-left":"\uf177","long-arrow-right":"\uf178","long-arrow-up":"\uf176","low-vision":"\uf2a8","magic":"\uf0d0","magnet":"\uf076","male":"\uf183","map":"\uf279","map-marker":"\uf041","map-o":"\uf278","map-pin":"\uf276","map-signs":"\uf277","mars":"\uf222","mars-double":"\uf227","mars-stroke":"\uf229","mars-stroke-h":"\uf22b","mars-stroke-v":"\uf22a","maxcdn":"\uf136","meanpath":"\uf20c","medium":"\uf23a","medkit":"\uf0fa","meetup":"\uf2e0","meh-o":"\uf11a","mercury":"\uf223","microchip":"\uf2db","microphone":"\uf130","microphone-slash":"\uf131","minus":"\uf068","minus-circle":"\uf056","minus-square":"\uf146","minus-square-o":"\uf147","mixcloud":"\uf289","mobile":"\uf10b","modx":"\uf285","money":"\uf0d6","moon-o":"\uf186","motorcycle":"\uf21c","mouse-pointer":"\uf245","music":"\uf001","neuter":"\uf22c","newspaper-o":"\uf1ea","object-group":"\uf247","object-ungroup":"\uf248","odnoklassniki":"\uf263","odnoklassniki-square":"\uf264","opencart":"\uf23d","openid":"\uf19b","opera":"\uf26a","optin-monster":"\uf23c","outdent":"\uf03b","pagelines":"\uf18c","paint-brush":"\uf1fc","paper-plane":"\uf1d8","paper-plane-o":"\uf1d9","paperclip":"\uf0c6","paragraph":"\uf1dd","pause":"\uf04c","pause-circle":"\uf28b","pause-circle-o":"\uf28c","paw":"\uf1b0","paypal":"\uf1ed","pencil":"\uf040","pencil-square":"\uf14b","pencil-square-o":"\uf044","percent":"\uf295","phone":"\uf095","phone-square":"\uf098","picture-o":"\uf03e","pie-chart":"\uf200","pied-piper":"\uf2ae","pied-piper-alt":"\uf1a8","pied-piper-pp":"\uf1a7","pinterest":"\uf0d2","pinterest-p":"\uf231","pinterest-square":"\uf0d3","plane":"\uf072","play":"\uf04b","play-circle":"\uf144","play-circle-o":"\uf01d","plug":"\uf1e6","plus":"\uf067","plus-circle":"\uf055","plus-square":"\uf0fe","plus-square-o":"\uf196","podcast":"\uf2ce","power-off":"\uf011","print":"\uf02f","product-hunt":"\uf288","puzzle-piece":"\uf12e","qq":"\uf1d6","qrcode":"\uf029","question":"\uf128","question-circle":"\uf059","question-circle-o":"\uf29c","quora":"\uf2c4","quote-left":"\uf10d","quote-right":"\uf10e","random":"\uf074","ravelry":"\uf2d9","rebel":"\uf1d0","recycle":"\uf1b8","reddit":"\uf1a1","reddit-alien":"\uf281","reddit-square":"\uf1a2","refresh":"\uf021","registered":"\uf25d","renren":"\uf18b","repeat":"\uf01e","reply":"\uf112","reply-all":"\uf122","retweet":"\uf079","road":"\uf018","rocket":"\uf135","rss":"\uf09e","rss-square":"\uf143","rub":"\uf158","safari":"\uf267","scissors":"\uf0c4","scribd":"\uf28a","search":"\uf002","search-minus":"\uf010","search-plus":"\uf00e","sellsy":"\uf213","server":"\uf233","share":"\uf064","share-alt":"\uf1e0","share-alt-square":"\uf1e1","share-square":"\uf14d","share-square-o":"\uf045","shield":"\uf132","ship":"\uf21a","shirtsinbulk":"\uf214","shopping-bag":"\uf290","shopping-basket":"\uf291","shopping-cart":"\uf07a","shower":"\uf2cc","sign-in":"\uf090","sign-language":"\uf2a7","sign-out":"\uf08b","signal":"\uf012","simplybuilt":"\uf215","sitemap":"\uf0e8","skyatlas":"\uf216","skype":"\uf17e","slack":"\uf198","sliders":"\uf1de","slideshare":"\uf1e7","smile-o":"\uf118","snapchat":"\uf2ab","snapchat-ghost":"\uf2ac","snapchat-square":"\uf2ad","snowflake-o":"\uf2dc","sort":"\uf0dc","sort-alpha-asc":"\uf15d","sort-alpha-desc":"\uf15e","sort-amount-asc":"\uf160","sort-amount-desc":"\uf161","sort-asc":"\uf0de","sort-desc":"\uf0dd","sort-numeric-asc":"\uf162","sort-numeric-desc":"\uf163","soundcloud":"\uf1be","space-shuttle":"\uf197","spinner":"\uf110","spoon":"\uf1b1","spotify":"\uf1bc","square":"\uf0c8","square-o":"\uf096","stack-exchange":"\uf18d","stack-overflow":"\uf16c","star":"\uf005","star-half":"\uf089","star-half-o":"\uf123","star-o":"\uf006","steam":"\uf1b6","steam-square":"\uf1b7","step-backward":"\uf048","step-forward":"\uf051","stethoscope":"\uf0f1","sticky-note":"\uf249","sticky-note-o":"\uf24a","stop":"\uf04d","stop-circle":"\uf28d","stop-circle-o":"\uf28e","street-view":"\uf21d","strikethrough":"\uf0cc","stumbleupon":"\uf1a4","stumbleupon-circle":"\uf1a3","subscript":"\uf12c","subway":"\uf239","suitcase":"\uf0f2","sun-o":"\uf185","superpowers":"\uf2dd","superscript":"\uf12b","table":"\uf0ce","tablet":"\uf10a","tachometer":"\uf0e4","tag":"\uf02b","tags":"\uf02c","tasks":"\uf0ae","taxi":"\uf1ba","telegram":"\uf2c6","television":"\uf26c","tencent-weibo":"\uf1d5","terminal":"\uf120","text-height":"\uf034","text-width":"\uf035","th":"\uf00a","th-large":"\uf009","th-list":"\uf00b","themeisle":"\uf2b2","thermometer-empty":"\uf2cb","thermometer-full":"\uf2c7","thermometer-half":"\uf2c9","thermometer-quarter":"\uf2ca","thermometer-three-quarters":"\uf2c8","thumb-tack":"\uf08d","thumbs-down":"\uf165","thumbs-o-down":"\uf088","thumbs-o-up":"\uf087","thumbs-up":"\uf164","ticket":"\uf145","times":"\uf00d","times-circle":"\uf057","times-circle-o":"\uf05c","tint":"\uf043","toggle-off":"\uf204","toggle-on":"\uf205","trademark":"\uf25c","train":"\uf238","transgender":"\uf224","transgender-alt":"\uf225","trash":"\uf1f8","trash-o":"\uf014","tree":"\uf1bb","trello":"\uf181","tripadvisor":"\uf262","trophy":"\uf091","truck":"\uf0d1","try":"\uf195","tty":"\uf1e4","tumblr":"\uf173","tumblr-square":"\uf174","twitch":"\uf1e8","twitter":"\uf099","twitter-square":"\uf081","umbrella":"\uf0e9","underline":"\uf0cd","undo":"\uf0e2","universal-access":"\uf29a","university":"\uf19c","unlock":"\uf09c","unlock-alt":"\uf13e","upload":"\uf093","usb":"\uf287","usd":"\uf155","user":"\uf007","user-circle":"\uf2bd","user-circle-o":"\uf2be","user-md":"\uf0f0","user-o":"\uf2c0","user-plus":"\uf234","user-secret":"\uf21b","user-times":"\uf235","users":"\uf0c0","venus":"\uf221","venus-double":"\uf226","venus-mars":"\uf228","viacoin":"\uf237","viadeo":"\uf2a9","viadeo-square":"\uf2aa","video-camera":"\uf03d","vimeo":"\uf27d","vimeo-square":"\uf194","vine":"\uf1ca","vk":"\uf189","volume-control-phone":"\uf2a0","volume-down":"\uf027","volume-off":"\uf026","volume-up":"\uf028","weibo":"\uf18a","weixin":"\uf1d7","whatsapp":"\uf232","wheelchair":"\uf193","wheelchair-alt":"\uf29b","wifi":"\uf1eb","wikipedia-w":"\uf266","window-close":"\uf2d3","window-close-o":"\uf2d4","window-maximize":"\uf2d0","window-minimize":"\uf2d1","window-restore":"\uf2d2","windows":"\uf17a","wordpress":"\uf19a","wpbeginner":"\uf297","wpexplorer":"\uf2de","wpforms":"\uf298","wrench":"\uf0ad","xing":"\uf168","xing-square":"\uf169","y-combinator":"\uf23b","yahoo":"\uf19e","yelp":"\uf1e9","yoast":"\uf2b1","youtube":"\uf167","youtube-play":"\uf16a","youtube-square":"\uf166"};

      // add context menu button
      context.memo('button.faicon', function () {
        return ui.buttonGroup({
          className: 'note-ext-faicon',
          children: [
						ui.button({
							className: 'dropdown-toggle',
							contents: '<i class="fa fa-smile-o"/>' + ' ' + ui.icon(options.icons.caret, 'span'),
							tooltip: 'Icon',
							data: {
								toggle: 'dropdown'
							},
              click: function() {
                // Cursor position must be saved because is lost when search is clicked
                context.invoke('editor.saveRange');
              }
						}),
						ui.dropdown({
							className: 'dropdown-faicon',
              items: [
									'<li>',
									'<div>',
									'  <div class="note-ext-faicon-search">',
									'  <input type="text" placeholder="search..." class="form-control" />',
									'  </div>',
									'  <div class="note-ext-faicon-list" />',
									'</div>',
									'</li>'
								].join(''),
              callback: function ($dropdown) {
              	self.$search = $('.note-ext-faicon-search :input', $dropdown);
              	self.$list = $('.note-ext-faicon-list', $dropdown);
              }
						})
					]
				}).render();
      });


      // You can create elements for plugin
      self.initialize = function () {
      	var $search = self.$search;
      	var $list = self.$list;

				// fill/activate the elements in the inline dialog.
				self.$search.keyup(function () {
						self.filter($search.val());
					});

				// create icons by list
				$.each(fa_icons, function (icon_name, hex_code) {
						$list.append('<button title="' + icon_name + '" data-hexcode="' + hex_code + '"><i class="fa fa-' + icon_name + '"></i></button>');
					});

				$("button", $list).click(function (event) {
						var $button = $(this);
						event.preventDefault(); // else, editor form is submitted
						context.invoke('faicon.insertIcon', $button.attr('title'), $button.data("hexcode"));
					});
      };


      // apply search filter on each key press in search input
      self.filter = function (filter) {
				var $icons = $('button', self.$list);
				var rx_filter;

				if (filter === '')
				{
					$icons.show();
				}
				else
				{
					rx_filter = new RegExp(filter);
					$icons.each(function() {
							var $item = $(this);

							if (rx_filter.test($item.attr('title')))
							{
								$item.show();
							}
							else
							{
								$item.hide();
							}
						});
				}
      };


			self.insertIcon = function (icon_name, hex_code) {
				var $fa = $('<span class="ext-faicon-subst fa">' + hex_code + '</span>').attr("data-icon", '');

        // We restore cursor position and element is inserted in correct pos.
        context.invoke('editor.restoreRange');
        context.invoke('editor.focus');

				// console.log("insert icon: ", icon_name);
				context.invoke('editor.insertNode', $fa[0]);
			};

    }
  });

}));
