// fix znikającego paska wyszukiwania po kliknięciu na niego
$(document).ready(function(){
	$('.navbar-right').on('click', '.dropdown-menu', function(e){
	e.stopPropagation();
	});
});

// dodawanie linku do menu kontekstowego prawego przycisku, oraz wstrzykiwanie nowej metody do angulara
// (function(angular) {
//     'use strict';
//     var app = angular.module('FileManagerApp');

// 	setTimeout(function() {
// 	  // The new element to be added
// 	  var $div = $('<li ng-show="singleSelection() && !singleSelection().isFolder()"><a href="#" tabindex="-1" ng-click="$scope.copyLink()" class="ng-binding"><i class="glyphicon glyphicon-link"></i> Kopiuj link</a></li>');
// 	  // The parent of the new element
// 	  var $target = $(".dropdown-right-click");

// 	  angular.element($target).injector().invoke(function($compile) {
// 	    var $scope = angular.element($target).scope();
// 	    $target.prepend($compile($div)($scope));
// 	    // Finally, refresh the watch expressions in the new element
// 	    $scope.$apply();
// 	  });
// 	}, 100);

// })(angular);

// download button in pdf and image preview
(function(angular) {
    'use strict';
    var app = angular.module('FileManagerApp');

	setTimeout(function() {
	  // The new element to be added
	  var $div = $('<a href="" tabindex="-1" ng-click="download()" class="btn btn-default ng-binding"><i class="glyphicon glyphicon-cloud-download"></i> Pobierz</a>');
	  // The parent of the new element
	  var $target = $("#imagepreview .modal-dialog .modal-footer");

	  angular.element($target).injector().invoke(function($compile) {
	    var $scope = angular.element($target).scope();
	    $target.prepend($compile($div)($scope));
	    // Finally, refresh the watch expressions in the new element
	    $scope.$apply();
	  });
	}, 100);

})(angular);

// OTWÓRZ W NOWEJ KARCIE
(function(angular) {
    'use strict';
    var app = angular.module('FileManagerApp');

	setTimeout(function() {
	  // The new element to be added
	  var $div = $('<a href="" tabindex="-1" ng-click="openInNewTab()" class="btn btn-default ng-binding"><i class="glyphicon glyphicon-share"></i> Otwórz w nowej karcie</a>');
	  // The parent of the new element
	  var $target = $("#imagepreview .modal-dialog .modal-footer");

	  angular.element($target).injector().invoke(function($compile) {
	    var $scope = angular.element($target).scope();
	    $target.prepend($compile($div)($scope));
	    // Finally, refresh the watch expressions in the new element
	    $scope.$apply();
	  });
	}, 100);

})(angular);