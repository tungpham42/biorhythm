// AddThis Config
lang = $.cookie('NSH:lang');
var addthis_config = {
	data_track_clickback: true
}
var addthis_share = {
	url_transforms : {
		shorten: {
			twitter: 'bitly',
			facebook: 'bitly'
		}
	}, 
	shorteners : {
		bitly : {} 
	}
}
addthis.layers({
	'theme' : 'transparent',
	'domain' : 'nhipsinhhoc.vn',
	'share' : {
		'position' : 'left',
		'numPreferredServices' : 5
	}, 
	'follow' : {
		'services' : [
			{'service': 'facebook', 'id': 'bieudonhipsinhhoc'},
			{'service': 'twitter', 'id': 'tungpham42'},
			{'service': 'linkedin', 'id': 'tungpham42'},
			{'service': 'google_follow', 'id': '104674084826641576435'}
		]
	}
});
