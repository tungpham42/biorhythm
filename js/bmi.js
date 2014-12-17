function roundTwoDecimal(number) {
	return Math.round(number*100)/100;
}
function calculateBmi(weight,height) {
	return roundTwoDecimal(weight/Math.pow(height,2));
}
function calculateWeight(bmi,height) {
	return Math.round(bmi*Math.pow(height,2));
}
function calculateHeight(bmi,weight) {
	return roundTwoDecimal(Math.sqrt(weight/bmi));
}
var bmiApp = angular.module('bmiApp', []);
bmiApp.controller('bmiController', ['$scope', function($scope) {
	$scope.bmiValue = function(){
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			return calculateBmi($scope.weight,$scope.height);
		}
	}
	$scope.bmiExplanation = function(){
		if (!isNaN($scope.bmiValue())) {
			if ($scope.bmiValue() < 15) {
				return 'gầy độ 3';
			} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
				return 'gầy độ 2';
			} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
				return 'gầy độ 1';
			} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
				return 'bình thường';
			} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
				return 'thừa cân';
			} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
				return 'béo phì độ 1';
			} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
				return 'béo phì độ 2';
			} else if ($scope.bmiValue() > 40) {
				return 'béo phì độ 3';
			}
		}
	}
	$scope.minWeight = function(){
		if (isset($scope.height) && $.isNumeric($scope.height) && !isEmpty('#height')) {
			if (calculateBmi(calculateWeight(18.5,$scope.height),$scope.height) < 18.5) {
				return calculateWeight(18.5,$scope.height)+1;
			} else if (calculateBmi(calculateWeight(18.5,$scope.height),$scope.height) >= 18.5 && calculateBmi(calculateWeight(18.5,$scope.height),$scope.height) <= 25) {
				return calculateWeight(18.5,$scope.height);
			}
		}
	}
	$scope.maxWeight = function(){
		if (isset($scope.height) && $.isNumeric($scope.height) && !isEmpty('#height')) {
			if (calculateBmi(calculateWeight(25,$scope.height),$scope.height) > 25) {
				return calculateWeight(25,$scope.height)-1;
			} else if (calculateBmi(calculateWeight(25,$scope.height),$scope.height) >= 18.5 && calculateBmi(calculateWeight(25,$scope.height),$scope.height) <= 25) {
				return calculateWeight(25,$scope.height);
			}
		}
	}
	$scope.idealWeight = function(){
		if (isset($scope.height) && $.isNumeric($scope.height) && !isEmpty('#height')) {
			return 'từ ' + $scope.minWeight() + ' đến ' + $scope.maxWeight() + ' ký';
		}
	}
	$scope.minHeight = function(){
		if (isset($scope.weight) && $.isNumeric($scope.weight) && !isEmpty('#weight')) {
			if (calculateBmi($scope.weight,calculateHeight(25,$scope.weight)) > 25) {
				return roundTwoDecimal(calculateHeight(25,$scope.weight)+0.01);
			} else if (calculateBmi($scope.weight,calculateHeight(25,$scope.weight)) >= 18.5 && calculateBmi($scope.weight,calculateHeight(25,$scope.weight)) <= 25) {
				return calculateHeight(25,$scope.weight);
			}
		}
	}
	$scope.maxHeight = function(){
		if (isset($scope.weight) && $.isNumeric($scope.weight) && !isEmpty('#weight')) {
			if (calculateBmi($scope.weight,calculateHeight(18.5,$scope.weight)) < 18.5) {
				return roundTwoDecimal(calculateHeight(18.5,$scope.weight)-0.01);
			} else if (calculateBmi($scope.weight,calculateHeight(18.5,$scope.weight)) >= 18.5 && calculateBmi($scope.weight,calculateHeight(18.5,$scope.weight)) <= 25) {
				return calculateHeight(18.5,$scope.weight);
			}
		}
	}
	$scope.idealHeight = function(){
		if (isset($scope.weight) && $.isNumeric($scope.weight) && !isEmpty('#weight')) {
			return 'từ ' + $scope.minHeight() + ' đến ' + $scope.maxHeight() + ' mét';
		}
	}
	$scope.change = function(){
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			if ($scope.weight < $scope.minWeight()) {
				return 'tăng';
			} else if ($scope.weight > $scope.maxWeight()) {
				return 'giảm';
			}
		}
	}
	$scope.weightChanged = function(){
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			if ($scope.weight < $scope.minWeight()) {
				return $scope.minWeight()-$scope.weight;
			} else if ($scope.weight > $scope.maxWeight()) {
				return $scope.weight-$scope.maxWeight();
			}
		}
	}
	$scope.recommendation = function(){		
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			if ($scope.weight < $scope.minWeight() || $scope.weight > $scope.maxWeight()) {
				return 'nên ' + $scope.change() + ' ' + $scope.weightChanged() + ' ký';
			} else if ($scope.weight >= $scope.minWeight() && $scope.weight <= $scope.maxWeight()) {
				return 'cần duy trì';
			}
		}
	}
}]);