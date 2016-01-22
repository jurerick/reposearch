(function() {
  var helpers;

  helpers = angular.module('helpers', []);

  helpers.factory('form', function() {
    return {
      getData: function(formObj) {
        var form, formData;
        formData = new Object();
        form = formObj.serializeArray();
        angular.forEach(form, function(obj, key) {
          return formData[obj.name] = obj.value;
        });
        return formData;
      }
    };
  });

  helpers.directive('spinner', function() {
    return {
      restrict: 'E',
      template: '<i class="fi-loop linear slow infinite spinner"></i>'
    };
  });

}).call(this);
