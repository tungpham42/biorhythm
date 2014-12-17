function hashController($scope,$http) {
	$http.get('http://nhipsinhhoc.vn/triggers/hash.php?unhashed='+$scope.unHashed).success(function(response) {
		$scope.hashedValue = response;
	});
}