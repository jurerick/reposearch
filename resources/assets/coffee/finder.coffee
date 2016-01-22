finder = angular.module 'finder', ['helpers', 'config']


finder.filter "sanitize", ['$sce', ($sce)->
  
  	return (htmlCode)->

  		$sce.trustAsHtml htmlCode
 ]

finder.directive 'alertMessage', ()->

	restrict: 'E'

	template: '<div class="alert callout alert-box" data-closable>
		<p><i class="fi-alert"></i> {{alertMessage}}</p>
	</div>'


finder.directive 'pagination', ($compile, $parse)->
	
	restrict: 'E'

	link: (scope, element, attr)->

		scope.$watch( attr.content, ()-> 

			element.html $parse(attr.content)(scope)

			$compile(element.contents())(scope)

		, true)


finder.controller 'FinderController', ['$scope', '$http', 'form', 'social', ($scope, $http, form, social)->

	$scope.repositories = []

	$scope.isSaving = false

	$scope.search = (e)->

		page = 1

		per_page = 10

		button = $(e.target)
		
		formObj = button.closest 'form'
		
		formObj.submit()

		formData = form.getData(formObj)

		url = social.githubApi + '/search/repositories?q=' + formData.q + '&page=' + page + '&per_page=' + per_page

		$scope.render(url)

	$scope.render = (url)->

		$scope.isSaving = true
		angular.element('.content-loader > spinner').removeClass 'hide'
		angular.element('.github-display').addClass 'hide'

		url += '&client_id=' + social.githubClientId + '&client_secret=' + social.githubClientSecret

		$http.get( url ).then(

			success = (response)->

				$scope.alertMessage = null

				$scope.repositories = response.data

				angular.element('#repositories-block').removeClass 'hide'

				links = $scope.parseHeaderLinks( response.headers('Link') )

				if $.isEmptyObject(links) is false
					$scope.pagination(links)

				$scope.isSaving = false

			error = (response)->

				$scope.alertMessage = 'Github error: ' + response.data.message

				$scope.isSaving = false

				# console.log 'Error encountered while loading items from Github. Please try again.'
		)

	$scope.pagination = (linkHeader)->

		prevDisabledClass = if angular.isUndefined(linkHeader.prev) then 'disabled' else ''
		nextDisabledClass = if angular.isUndefined(linkHeader.next) then 'disabled' else ''

		# Previous Page Link

		$scope.paginationContent = '<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous '+prevDisabledClass+'">'

		if (!angular.isUndefined(linkHeader.prev))
			$scope.paginationContent +=  '<a ng-click="goToUrl($event)" data-target_url="'+linkHeader.prev+'" href="javascript:void(0)">'
		
		$scope.paginationContent += 'Previous'
		
		if (!angular.isUndefined(linkHeader.prev))
			$scope.paginationContent += '</a>'


		# TODO: Create a page numbers Links


		# Next Page Link

		$scope.paginationContent += '</li>
			<li class="pagination-next '+nextDisabledClass+'">'
		
		if (!angular.isUndefined(linkHeader.next))
			$scope.paginationContent += '<a aria-label="Next page" ng-click="goToUrl($event)" data-target_url="'+linkHeader.next+'" href="javascript:void(0)">'
		
		$scope.paginationContent += 'Next'
		
		if (!angular.isUndefined(linkHeader.next))
			$scope.paginationContent += '</a>'

		$scope.paginationContent +=  '</li>
		</ul>'

	$scope.goToUrl = (e)->

		$scope.render $(e.target).data('target_url')


	$scope.parseHeaderLinks = (links)->

		linksData = {}

		if links

			parts = links.split(',')

			angular.forEach parts, (part)->

				section = part.split(';')

				url = section[0].replace(/<(.*)>/, '$1').trim()

				name = section[1].replace(/rel="(.*)"/, '$1').trim()

				linksData[name] = url

		return linksData

]