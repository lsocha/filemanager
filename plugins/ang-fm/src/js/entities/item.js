(function(angular) {
    'use strict';
    angular.module('FileManagerApp').factory('item', ['fileManagerConfig', 'chmod', function(fileManagerConfig, Chmod) {

        var Item = function(model, path) {
            var rawModel = {
                name: model && model.name || '',
                path: path || [],
                filepath: model.filepath || [],
                extension: model.extension || [],
                type: model && model.type || 'file',
                size: model && parseInt(model.size || 0),
                date: parseMySQLDate(model && model.date),
                perms: new Chmod(model && model.rights),
                content: model && model.content || '',
                recursive: false,
                fullPath: function() {
                    var path = this.path.filter(Boolean);
                    return ('/' + path.join('/') + '/' + this.name).replace(/\/\//, '/');
                }
            };

            this.error = '';
            this.processing = false;

            this.model = angular.copy(rawModel);
            this.tempModel = angular.copy(rawModel);

            function parseMySQLDate(mysqlDate) {
                var d = (mysqlDate || '').toString().split(/[- :]/);
                var date = new Date(d[0], d[1] - 1, d[2], d[3], d[4], d[5]);
                date.setHours(date.getHours()+4);
                return date;
            }
        };

        Item.prototype.update = function() {
            angular.extend(this.model, angular.copy(this.tempModel));
        };

        Item.prototype.revert = function() {
            angular.extend(this.tempModel, angular.copy(this.model));
            this.error = '';
        };

        Item.prototype.isFolder = function() {
            return this.model.type === 'dir';
        };

        Item.prototype.isEditable = function() {
            return !this.isFolder() && fileManagerConfig.isEditableFilePattern.test(this.model.name);
        };

        Item.prototype.isImage = function() {
            return fileManagerConfig.isImageFilePattern.test(this.model.name);
            // if(fileManagerConfig.isImageFilePattern.test(this.model.name)) this.model.type ='image';
            // return fileManagerConfig.isImageFilePattern.test(this.model.name);
        };

        Item.prototype.isPdf = function() {
            return fileManagerConfig.isPdfFilePattern.test(this.model.name);
        };

        Item.prototype.isCompressible = function() {
            return this.isFolder();
        };

        Item.prototype.isExtractable = function() {
            return !this.isFolder() && fileManagerConfig.isExtractableFilePattern.test(this.model.name);
        };

        Item.prototype.isSelectable = function() {
            return (this.isFolder() && fileManagerConfig.allowedActions.pickFolders) || (!this.isFolder() && fileManagerConfig.allowedActions.pickFiles);
        };

        return Item;
    }]);
})(angular);