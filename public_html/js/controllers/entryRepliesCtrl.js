angular.module('entryRepliesCtrl', [])

    // inject the Comment service into our controller
    .controller('entryRepliesController', function($scope, $http, $location, EntryReply) {
        var entryId = $location.path().split('/')[4];

        // object to hold all the data for the new comment form
        $scope.EntryReplyData = {};

        $scope.error= "";

        // loading variable to show the spinning loading icon
        $scope.loading = true;
        $scope.showForm = [];

        $scope.auth_user_id = constants.auth_user_id;
        $scope.entry_user_id = constants.entry_user_id;

        // get all the comments first and bind it to the $scope.comments object
        // use the function we created in our service
        // GET ALL COMMENTS ==============
        EntryReply.get(entryId)
            .success(function(data) {
                $scope.comments = data;
                $scope.loading = false;
            });

        // function to handle submitting the form
        // SAVE A COMMENT ================
        $scope.submitComment = function() {
            $scope.loading = true;

            // save the comment. pass in comment data from the form
            // use the function we created in our service
            EntryReply.save($scope.EntryReplyData)
                .success(function(data) {

                    // if successful, we'll need to refresh the comment list
                    EntryReply.get(entryId)
                        .success(function(getData) {
                            $scope.comments = getData;
                            $scope.loading = false;
                        });

                })
                .error(function(data) {
                    console.log(data);
                    $scope.error = "error!!";
                });

            $scope.EntryReplyData.content = "";
        };

        $scope.toggleForm = function (index) {
            $scope.showForm[index] = ! $scope.showForm[index];

            var form = document.getElementById(index);
            $scope.EntryReplyData.user_id = form.getElementsByClassName('user_id')[0].value;
            $scope.EntryReplyData.blog_id = form.getElementsByClassName('blog_id')[0].value;
            $scope.EntryReplyData.entry_id = form.getElementsByClassName('entry_id')[0].value;
            $scope.EntryReplyData.reply_id = form.getElementsByClassName('reply_id')[0].value;
            $scope.EntryReplyData._token = form.getElementsByClassName('_token')[0].value;
        }

        // function to handle deleting a comment
        // DELETE A COMMENT ====================================================
        $scope.deleteComment = function(id) {
            if (confirm('¿Seguro que desea realizar la operación?'))
            {
                $scope.loading = true;

                // use the function we created in our service
                EntryReply.destroy(id)
                    .success(function(data) {

                        // if successful, we'll need to refresh the comment list
                        EntryReply.get(entryId)
                            .success(function(getData) {
                                $scope.comments = getData;
                                $scope.loading = false;
                            });

                    });
            }
        };

    });