define(["jquery", "core/ajax"], function($, ajax) {
    var darkmenu = {
        init : function() {

            darkmenu.addmenu();

            // kraus-layout-dark
            var $layoutMode = $(".kraus-layout-dark div");
            $layoutMode.click(function() {
                $("body").addClass("dark-animation");
                setTimeout(function() {
                    $("body").removeClass("dark-animation");
                }, 500);

                var layout = "dark";
                if ($("html").attr("data-bs-theme") == "dark") {
                    layout = "light";
                }
                $("html").attr("data-bs-theme", layout);

                ajax.call([{
                    methodname : "local_boost_dark_userpreference_layout",
                    args       : {layout : layout}
                }]);
            });
        },

        addmenu : function() {
            var darkmenu =
                    `<div class="kraus-layout-dark">
                         <div class="dark-mode nav-link">
                             <svg style="width: 19px;" enable-background="new -52 -52 128 128" height="128" viewBox="-52 -52 128 128" width="128" xmlns="http://www.w3.org/2000/svg">
                                 <path fill="currentColor" d="m12.823 76c-17.085 0-33.789-6.941-45.826-19.045-12.248-12.246-18.997-28.562-18.997-45.935s6.749-33.687 19.003-45.935c8.074-8.042 18.161-13.842 29.174-16.776.758-.205 1.55-.309 2.344-.309.786 0 1.571.103 2.332.305 4.835 1.287 7.724 6.266 6.442 11.1-4.285 16.086.346 33.406 12.086 45.203 8.813 8.81 20.549 13.664 33.039 13.664 4.094 0 8.188-.534 12.17-1.59.755-.202 1.54-.305 2.326-.305.787 0 1.573.103 2.333.306 4.834 1.282 7.729 6.264 6.447 11.106-2.937 11.02-8.742 21.106-16.788 29.174-12.208 12.275-28.472 19.037-45.79 19.037-.002 0-.295 0-.295 0zm.28-18.151c12.285 0 24.302-4.997 32.967-13.71 2.341-2.352 4.418-4.93 6.205-7.7-17.03-.031-33.693-6.948-45.733-18.99-12.165-12.22-18.927-28.651-18.98-45.734-2.785 1.787-5.368 3.866-7.717 6.212-8.827 8.824-13.688 20.58-13.688 33.101 0 12.522 4.861 24.276 13.688 33.1 8.675 8.723 20.704 13.722 33.009 13.722h.105.144z"/>
                             </svg>
                         </div>
                         <div class="light-mode nav-link">
                             <svg style="width: 19px;" enable-background="new -52 -52 128 128" height="128" viewBox="-52 -52 128 128" width="128" xmlns="http://www.w3.org/2000/svg">
                             <path fill="currentColor" d="m3.021 76v-24.072h17.958v24.072zm-42.631-25.097 17.012-17.028 12.705 12.696-17.013 17.029zm73.492-4.324 12.697-12.697 17.02 17.025-12.692 12.692zm-21.87-1.104c-18.458 0-33.475-15.017-33.475-33.475s15.017-33.475 33.475-33.475 33.475 15.017 33.475 33.475-15.017 33.475-33.475 33.475zm0-48.991c-8.556 0-15.517 6.96-15.517 15.516s6.961 15.517 15.517 15.517c8.555 0 15.516-6.961 15.516-15.517s-6.961-15.516-15.516-15.516zm39.916 24.495v-17.958h24.072v17.958zm-103.928 0v-17.958h24.072v17.958zm12.394-47.881 12.706-12.694 17.011 17.022-12.69 12.699zm73.488 4.322 17.026-17.022 12.69 12.694-17.019 17.027zm-30.861-5.348v-24.072h17.958v24.072z"/>
                             </svg>
                         </div>
                     </div>`;
            $("#usernavigation").prepend(darkmenu);
        }
    };

    return darkmenu;
});
