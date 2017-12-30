var blogCommentsApp = angular.module('entryRepliesApp', ['entryRepliesCtrl', 'entryRepliesService'], function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $locationProvider.html5Mode(true);
});

blogCommentsApp.filter("nl2br", function($filter) {
    return function(data) {
        if (!data) return data;
        return data.replace(/\n\r?/g, '<br />');
    };
});

blogCommentsApp.filter('nl2p', function () {
    return function(text){
        text = String(text).trim();
        return (text.length > 0 ? '<p>' + text.replace(/[\r\n]+/g, '</p><p>') + '</p>' : null);
    };
});