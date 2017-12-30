angular.module('entryRepliesService', [])

    .factory('EntryReply', function($http) {

        return {
            // get all the comments
            get : function(entryId) {
                return $http.get('/blogs/replies/' + entryId);
            },

            // save a comment (pass in comment data)
            save : function(EntryReplyData) {
                return $http({
                    method: 'POST',
                    url: '/blogs/replies/store',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(EntryReplyData),
                    csrf_token: EntryReplyData._token
                });
            },

            // destroy a comment
            destroy : function(id) {
                return $http.delete('/blogs/replies/' + id + '/destroy');
            }
        }

    });