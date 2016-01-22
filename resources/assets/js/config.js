(function() {
  var config;

  config = angular.module('config', []);

  config.factory('social', function() {
    return {
      githubApi: 'https://api.github.com',
      githubClientId: 'a990d54217bb2c28fdf0',
      githubClientSecret: '63b75f335fcb58166d53efd16cc0997d280d1710'
    };
  });

}).call(this);
