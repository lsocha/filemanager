<div id="filemanager" ng-app="FileManagerApp">

  <!-- third party -->
    <script src="./plugins/ang-fm/bower_components/angular/angular.min.js"></script>
    <script src="./plugins/ang-fm/bower_components/angular-translate/angular-translate.min.js"></script>
    <script src="./plugins/ang-fm/bower_components/ng-file-upload/ng-file-upload.min.js"></script>
    <!-- <script src="./plugins/ang-fm/bower_components/jquery/dist/jquery.min.js"></script> -->
    <!-- <script src="./plugins/ang-fm/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- <link rel="stylesheet" href="./plugins/ang-fm/bower_components/bootswatch/paper/bootstrap.min.css" /> -->
    <link href="./css/dokumenty_paper.css" rel="stylesheet">
  <!-- /third party -->

  <!-- Uncomment if you need to use raw source code  -->
<!--     <script src="./plugins/ang-fm/src/js/app.js"></script>
    <script src="./plugins/ang-fm/src/js/directives/directives.js"></script>
    <script src="./plugins/ang-fm/src/js/filters/filters.js"></script>
    <script src="./plugins/ang-fm/src/js/providers/config.js"></script>
    <script src="./plugins/ang-fm/src/js/entities/chmod.js"></script>
    <script src="./plugins/ang-fm/src/js/entities/item.js"></script>
    <script src="./plugins/ang-fm/src/js/services/apihandler.js"></script>
    <script src="./plugins/ang-fm/src/js/services/apimiddleware.js"></script>
    <script src="./plugins/ang-fm/src/js/services/filenavigator.js"></script>
    <script src="./plugins/ang-fm/src/js/providers/translations.js"></script>
    <script src="./plugins/ang-fm/src/js/controllers/main.js"></script>
    <script src="./plugins/ang-fm/src/js/controllers/selector-controller.js"></script>
    <link href="./plugins/ang-fm/src/css/animations.css" rel="stylesheet">
    <link href="./plugins/ang-fm/src/css/dialogs.css" rel="stylesheet">
    <link href="./plugins/ang-fm/src/css/main.css" rel="stylesheet"> -->


  <!-- Comment if you need to use raw source code -->
    <link href="./plugins/ang-fm/dist/angular-filemanager.min.css" rel="stylesheet">
    <script src="./plugins/ang-fm/dist/angular-filemanager.min.js"></script>
  <!-- /Comment if you need to use raw source code -->

  <!-- nadisanie wartości zmienionymi core'owymi plikami -->
  <script src="./plugins/ang-fm/src/js/providers/config.js"></script>
  <script src="./plugins/ang-fm/src/js/entities/item.js"></script>
  <script src="./plugins/ang-fm/src/js/services/apimiddleware.js"></script>
  <script src="./plugins/ang-fm/src/js/providers/translations.js"></script>
  <script src="./plugins/ang-fm/src/js/controllers/main.js"></script>

  <!-- doane do main.css .modal-dialog { z-index: 1041; } -->
<!--   <link href="./plugins/ang-fm/src/css/animations.css" rel="stylesheet">
  <link href="./plugins/ang-fm/src/css/dialogs.css" rel="stylesheet">
  <link href="./plugins/ang-fm/src/css/main.css" rel="stylesheet"> -->
  <link href="./css/dokumenty.css" rel="stylesheet">


  
  <script type="text/javascript">
    //example to override angular-filemanager default config
    angular.module('FileManagerApp').config(['fileManagerConfigProvider', function (config) {
      var defaults = config.$get();
      config.set({
        appName: 'angular-filemanager',
        pickCallback: function(item) {
          var msg = 'Picked %s "%s" for external use'
            .replace('%s', item.type)
            .replace('%s', item.fullPath());
          window.alert(msg);
        },

        defaultLang: 'pl',
        // zmiana bridge na php-local
        listUrl: './plugins/ang-fm/bridges/php-local/index.php',
        uploadUrl: './plugins/ang-fm/bridges/php-local/index.php',
        renameUrl: './plugins/ang-fm/bridges/php-local/index.php',
        copyUrl: './plugins/ang-fm/bridges/php-local/index.php',
        moveUrl: './plugins/ang-fm/bridges/php-local/index.php',
        removeUrl: './plugins/ang-fm/bridges/php-local/index.php',
        editUrl: './plugins/ang-fm/bridges/php-local/index.php',
        getContentUrl: './plugins/ang-fm/bridges/php-local/index.php',
        createFolderUrl: './plugins/ang-fm/bridges/php-local/index.php',
        downloadFileUrl: './plugins/ang-fm/bridges/php-local/index.php',
        downloadMultipleUrl: './plugins/ang-fm/bridges/php-local/index.php',
        compressUrl: './plugins/ang-fm/bridges/php-local/index.php',
        extractUrl: './plugins/ang-fm/bridges/php-local/index.php',
        permissionsUrl: './plugins/ang-fm/bridges/php-local/index.php',
        // domyślnie nie jest dozowlona żadna akcja, sprawdzamy uprawnienia i nadpisujemy dozowolone dla danej roli akcje
        allowedActions: {
		                upload: false,
		                rename: false,
		                move: false,
		                copy: false,
		                edit: false,
		                changePermissions: false,
		                compress: false,
		                compressChooseName: false,
		                extract: false,
		                download: false,
		                downloadMultiple: false,
		                preview: false,
		                remove: false,
		                createFolder: false,
		                pickFiles: false,
		                pickFolders: false,
                    
                  <?php 	
                    if($ACL['dokumenty']['rd'] == 1) {
            		        echo "download: true,
            		              downloadMultiple: true,
            		              preview: true,";
                    } 
                    if($ACL['dokumenty']['wr'] == 1) {
            		        echo "rename: true,
            		              move: true,
            		              copy: true,
            		              edit: true,
            		              compress: true,
            		              compressChooseName: true,
            		              extract: true,";
                    } 
                    if($ACL['dokumenty']['nw'] == 1) {
            		        echo "upload: true,
            		              rename: true,
            		              move: true,
            		              copy: true,
            		              createFolder: true,";
                    } 
                    if($ACL['dokumenty']['rm'] == 1) {
            		        echo "remove: true,";
                    }
                  ?>
		    }, //klamra allowed actions
      });
    }]);
  </script>

  <div class="ng-cloak">
    <angular-filemanager></angular-filemanager>
    <?php
    	// if($ACL['dokumenty']['rd'] == 1) echo "<angular-filemanager></angular-filemanager>";
    	// else echo "<div class='alert alert-danger'><strong>Error!</strong> You don't have permissions to view this site.</div>";
    ?>
  </div>

</div>
