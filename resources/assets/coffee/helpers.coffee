helpers = angular.module 'helpers', []

helpers.factory 'form', ()->

	getData: (formObj)->
		formData = new Object()
		form = formObj.serializeArray()
		angular.forEach form, (obj, key)->
			formData[obj.name] = obj.value
		return formData

helpers.directive 'spinner', ()->
	restrict: 'E'
	template: '<i class="fi-loop linear slow infinite spinner"></i>'




