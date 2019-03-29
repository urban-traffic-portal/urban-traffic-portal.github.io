/**
 * Created by softech on 3/13/16.
 */

var siteName = 'AngularJS Training';

/**
 * pageTitle - Directive for set Page title - meta title
 */
function pageTitle($rootScope, $timeout) {
    return {
        link: function(scope, element) {
            var listener = function(event, toState, toParams, fromState, fromParams) {
                // Default title - load on Dashboard 1
                var title = siteName;
                // Create your own title pattern
                if (toState.data && toState.data.pageTitle)
                    title = siteName + ' | ' + toState.data.pageTitle;

                $timeout(function() {
                    element.text(title);
                });
            };
            $rootScope.$on('$stateChangeStart', listener);
        }
    }
}

function copyright() {
    return {
        link: function(scope, element) {
            element.html('<hr/>Aptech 2016');
        }
    }
}


app
    .directive('pageTitle', pageTitle)
    .directive('copyright', copyright)
