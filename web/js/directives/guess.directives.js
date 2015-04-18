angular.module('guess.directives', [])
.directive('modal', function () {
    return {
      template: '<div class="modal fade">' + 
          '<div class="modal-dialog">' + 
            '<div class="modal-content">' + 
              '<div class="modal-header">' + 
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                '<h4 class="modal-title">{{ title }}</h4>' + 
              '</div>' + 
              '<div class="modal-body" ng-transclude></div>' + 
            '</div>' + 
          '</div>' + 
        '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs) {
        scope.title = attrs.title;

        scope.$watch(attrs.visible, function(value){
          if(value == true)
            $(element).modal('show');
          else
            $(element).modal('hide');
        });

        $(element).on('shown.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = true;
          });
        });

        $(element).on('hidden.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = false;
          });
        });
      }
    };
  })
  
.directive('highlightOnChange', function() {
  return {
    link : function(scope, element, attrs) {
      attrs.$observe( 'highlightOnChange', function ( val ) {
		  var kda = element.html().trim();
		  var actualKDA = 1;
		  if (kda.length < 12){
			  kda = kda.split("/");
			  if (kda[1] == '0'){
				  kda[1] = '1';
			  }
			  actualKDA = (parseInt(kda[0]) + parseInt(kda[2])) / parseFloat(kda[1])
		  }
		  var color = '255, 255, 255';
		  if(actualKDA > 1 ){
			  color = '13, 211, 13, '+ actualKDA / parseFloat(5);
		  } else if (actualKDA < 1 ) {
			  color = '255, 37, 37, ' + actualKDA;
		  }
		  element.css('background-color', 'rgb(13, 211, 13)');
		  element.effect('highlight');
      });
    }
  };
});