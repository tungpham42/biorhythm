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
	$scope.language = function(){
		return $('#bmi_lang').val();
	};
	$scope.bmiValue = function(){
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			return calculateBmi($scope.weight,$scope.height);
		}
	}
	$scope.bmiExplanation = function(){
		if (!isNaN($scope.bmiValue())) {
			switch ($scope.language()) {
				case 'vi':
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
					break;
				case 'en':
					if ($scope.bmiValue() < 15) {
						return 'very severely underweight';
					} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
						return 'severely underweight';
					} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
						return 'underweight';
					} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
						return 'healthy weight';
					} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
						return 'overweight';
					} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
						return 'moderately obese';
					} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
						return 'severely obese';
					} else if ($scope.bmiValue() > 40) {
						return 'very severely obese';
					}
					break;
				case 'ru':
					if ($scope.bmiValue() < 15) {
						return 'очень серьезно вес';
					} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
						return 'недостаточный вес';
					} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
						return 'пониженная масса';
					} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
						return 'здоровый вес';
					} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
						return 'избыточный вес';
					} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
						return 'умеренно ожирением';
					} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
						return 'тяжелым ожирением';
					} else if ($scope.bmiValue() > 40) {
						return 'очень серьезно ожирением';
					}
					break;
				case 'es':
					if ($scope.bmiValue() < 15) {
						return 'muy muy inferior al normal';
					} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
						return 'muy inferior al normal';
					} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
						return 'bajo peso';
					} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
						return 'peso saludable';
					} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
						return 'sobrepeso';
					} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
						return 'moderadamente obesos';
					} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
						return 'obesidad severa';
					} else if ($scope.bmiValue() > 40) {
						return 'muy severamente obesos';
					}
					break;
				case 'zh':
					if ($scope.bmiValue() < 15) {
						return '很严重不足';
					} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
						return '体重严重不足';
					} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
						return '体重过轻';
					} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
						return '健康体重';
					} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
						return '超重';
					} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
						return '中度肥胖';
					} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
						return '严重肥胖';
					} else if ($scope.bmiValue() > 40) {
						return '非常严重肥胖';
					}
					break;
				case 'ja':
					if ($scope.bmiValue() < 15) {
						return '非常に深刻な低体重';
					} else if ($scope.bmiValue() >= 15 && $scope.bmiValue() < 16) {
						return '深刻な低体重';
					} else if ($scope.bmiValue() >= 16 && $scope.bmiValue() < 18.5) {
						return '重量不足';
					} else if ($scope.bmiValue() >= 18.5 && $scope.bmiValue() <= 25) {
						return '健康体重';
					} else if ($scope.bmiValue() > 25 && $scope.bmiValue() <= 30) {
						return '太り過ぎ';
					} else if ($scope.bmiValue() > 30 && $scope.bmiValue() <= 35) {
						return '適度に肥満';
					} else if ($scope.bmiValue() > 35 && $scope.bmiValue() <= 40) {
						return '重度の肥満';
					} else if ($scope.bmiValue() > 40) {
						return '非常に重度の肥満';
					}
					break;
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
			switch ($scope.language()) {
				case 'vi':
					return 'từ ' + $scope.minWeight() + ' đến ' + $scope.maxWeight() + ' ký';
					break;
				case 'en':
					return 'from ' + $scope.minWeight() + ' to ' + $scope.maxWeight() + ' kg';
					break;
				case 'ru':
					return 'от ' + $scope.minWeight() + ' до ' + $scope.maxWeight() + ' кг';
					break;
				case 'es':
					return 'de ' + $scope.minWeight() + ' a ' + $scope.maxWeight() + ' kilo';
					break;
				case 'zh':
					return '从' + $scope.minWeight() + '到' + $scope.maxWeight() + '千克';
					break;
				case 'ja':
					return $scope.minWeight() + '〜' + $scope.maxWeight() + 'キロから';
					break;
			}
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
			switch ($scope.language()) {
				case 'vi':
					return 'từ ' + $scope.minHeight() + ' đến ' + $scope.maxHeight() + ' mét';
					break;
				case 'en':
					return 'from ' + $scope.minHeight() + ' to ' + $scope.maxHeight() + ' metre';
					break;
				case 'ru':
					return 'от ' + $scope.minHeight() + ' до ' + $scope.maxHeight() + ' метр';
					break;
				case 'es':
					return 'de ' + $scope.minHeight() + ' a ' + $scope.maxHeight() + ' medidor';
					break;
				case 'zh':
					return '从' + $scope.minHeight() + '到' + $scope.maxHeight() + '计';
					break;
				case 'ja':
					return $scope.minHeight() + 'から' + $scope.maxHeight() + 'メートルへ';
					break;
			}
		}
	}
	$scope.change = function(){
		if (isset($scope.weight) && isset($scope.height) && $.isNumeric($scope.weight) && $.isNumeric($scope.height) && !isEmpty('#weight') && !isEmpty('#height')) {
			if ($scope.weight < $scope.minWeight()) {
				switch ($scope.language()) {
					case 'vi':
						return 'tăng';
						break;
					case 'en':
						return 'increase';
						break;
					case 'ru':
						return 'увеличение';
						break;
					case 'es':
						return 'aumentar';
						break;
					case 'zh':
						return '增加';
						break;
					case 'ja':
						return '増加する';
						break;
				}
			} else if ($scope.weight > $scope.maxWeight()) {
				switch ($scope.language()) {
					case 'vi':
						return 'giảm';
						break;
					case 'en':
						return 'decrease';
						break;
					case 'ru':
						return 'уменьшить';
						break;
					case 'es':
						return 'disminuir';
						break;
					case 'zh':
						return '减少';
						break;
					case 'ja':
						return '減少';
						break;
				}
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
				switch ($scope.language()) {
					case 'vi':
						return 'nên ' + $scope.change() + ' ' + $scope.weightChanged() + ' ký';
						break;
					case 'en':
						return 'should ' + $scope.change() + ' ' + $scope.weightChanged() + ' kg';
						break;
					case 'ru':
						return 'следует ' + $scope.change() + ' ' + $scope.weightChanged() + ' кг';
						break;
					case 'es':
						return 'deberían ' + $scope.change() + ' ' + $scope.weightChanged() + ' kilo';
						break;
					case 'zh':
						return '应该' + $scope.change() + $scope.weightChanged() + '千克';
						break;
					case 'ja':
						return 'べき' + $scope.change() + $scope.weightChanged() + 'キロ';
						break;
				}
			} else if ($scope.weight >= $scope.minWeight() && $scope.weight <= $scope.maxWeight()) {
				switch ($scope.language()) {
					case 'vi':
						return 'cần duy trì';
						break;
					case 'en':
						return 'good health';
						break;
					case 'ru':
						return 'хорошее здоровье';
						break;
					case 'es':
						return 'buena salud';
						break;
					case 'zh':
						return '安康';
						break;
					case 'ja':
						return '健勝';
						break;
				}
			}
		}
	}
}]);