(function() {
  var finder;

  finder = angular.module('finder', ['helpers', 'config']);

  finder.filter("sanitize", [
    '$sce', function($sce) {
      return function(htmlCode) {
        return $sce.trustAsHtml(htmlCode);
      };
    }
  ]);

  finder.directive('alertMessage', function() {
    return {
      restrict: 'E',
      template: '<div class="alert callout alert-box" data-closable> <p><i class="fi-alert"></i> {{alertMessage}}</p> </div>'
    };
  });

  finder.directive('pagination', function($compile, $parse) {
    return {
      restrict: 'E',
      link: function(scope, element, attr) {
        return scope.$watch(attr.content, function() {
          element.html($parse(attr.content)(scope));
          return $compile(element.contents())(scope);
        }, true);
      }
    };
  });

  finder.controller('FinderController', [
    '$scope', '$http', 'form', 'social', function($scope, $http, form, social) {
      $scope.repositories = [];
      $scope.isSaving = false;
      $scope.search = function(e) {
        var button, formData, formObj, page, per_page, url;
        page = 1;
        per_page = 10;
        button = $(e.target);
        formObj = button.closest('form');
        formObj.submit();
        formData = form.getData(formObj);
        url = social.githubApi + '/search/repositories?q=' + formData.q + '&page=' + page + '&per_page=' + per_page;
        return $scope.render(url);
      };
      $scope.render = function(url) {
        var error, success;
        $scope.isSaving = true;
        angular.element('.content-loader > spinner').removeClass('hide');
        angular.element('.github-display').addClass('hide');
        url += '&client_id=' + social.githubClientId + '&client_secret=' + social.githubClientSecret;
        return $http.get(url).then(success = function(response) {
          var links;
          $scope.alertMessage = null;
          $scope.repositories = response.data;
          angular.element('#repositories-block').removeClass('hide');
          links = $scope.parseHeaderLinks(response.headers('Link'));
          if ($.isEmptyObject(links) === false) {
            $scope.pagination(links);
          }
          return $scope.isSaving = false;
        }, error = function(response) {
          $scope.alertMessage = 'Github error: ' + response.data.message;
          return $scope.isSaving = false;
        });
      };
      $scope.pagination = function(linkHeader) {
        var nextDisabledClass, prevDisabledClass;
        prevDisabledClass = angular.isUndefined(linkHeader.prev) ? 'disabled' : '';
        nextDisabledClass = angular.isUndefined(linkHeader.next) ? 'disabled' : '';
        $scope.paginationContent = '<ul class="pagination" role="navigation" aria-label="Pagination"> <li class="pagination-previous ' + prevDisabledClass + '">';
        if (!angular.isUndefined(linkHeader.prev)) {
          $scope.paginationContent += '<a ng-click="goToUrl($event)" data-target_url="' + linkHeader.prev + '" href="javascript:void(0)">';
        }
        $scope.paginationContent += 'Previous';
        if (!angular.isUndefined(linkHeader.prev)) {
          $scope.paginationContent += '</a>';
        }
        $scope.paginationContent += '</li> <li class="pagination-next ' + nextDisabledClass + '">';
        if (!angular.isUndefined(linkHeader.next)) {
          $scope.paginationContent += '<a aria-label="Next page" ng-click="goToUrl($event)" data-target_url="' + linkHeader.next + '" href="javascript:void(0)">';
        }
        $scope.paginationContent += 'Next';
        if (!angular.isUndefined(linkHeader.next)) {
          $scope.paginationContent += '</a>';
        }
        return $scope.paginationContent += '</li> </ul>';
      };
      $scope.goToUrl = function(e) {
        return $scope.render($(e.target).data('target_url'));
      };
      return $scope.parseHeaderLinks = function(links) {
        var linksData, parts;
        linksData = {};
        if (links) {
          parts = links.split(',');
          angular.forEach(parts, function(part) {
            var name, section, url;
            section = part.split(';');
            url = section[0].replace(/<(.*)>/, '$1').trim();
            name = section[1].replace(/rel="(.*)"/, '$1').trim();
            return linksData[name] = url;
          });
        }
        return linksData;
      };
    }
  ]);

}).call(this);
