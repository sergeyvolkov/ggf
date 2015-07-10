var fs = require('fs-extra');
var path = require('path');
var RSVP = require('rsvp');
var chalk = require('chalk')

module.exports = {
  name: 'laravel-assets',

  isDevelopingAddon: function () {
    return true;
  },

  /**
   * Copy ember app layout to laravel resources
   *
   * @returns {*}
   * @private
   */
  _copyLayout: function () {
    return new RSVP.Promise(function(resolve, reject) {
      var layoutPath = path.resolve(this.frontendRootPath, 'dist/index.html');

      fs.exists(layoutPath, function (doesExist, error) {
        if (error || !doesExist) {
          reject(error || 'Layout path is not valid');
          return ;
        }

        resolve(layoutPath);
      });
    }.bind(this)).then(function(layoutPath) {
      return new RSVP.Promise(function(resolve, reject) {
        var destinationPath = path.resolve(this.backendRootPath, 'resources/views/app.blade.php');

        fs.copy(layoutPath, destinationPath, { replace: true }, function (error) {
          if (error) {
            reject(error || 'Layout path is not valid');
            return ;
          }

          resolve('File ' + destinationPath + ' has been successfully copied.');
        });
      }.bind(this));
    }.bind(this));
  },

  /**
   * Copy ember assets to laravel public folder
   *
   * @returns {*}
   * @private
   */
  _copyAssets: function () {
    return new RSVP.Promise(function(resolve, reject) {
      var assetsFolderPath = path.resolve(this.frontendRootPath, 'dist/assets');

      fs.exists(assetsFolderPath, function (doesExist, error) {
        if (error || !doesExist) {
          reject(error || 'Layout path is not valid');
          return ;
        }

        resolve(assetsFolderPath);
      });
    }.bind(this)).then(function(assetsFolderPath) {
        return new RSVP.Promise(function(resolve, reject) {
          var destinationFolderPath = path.resolve(this.backendRootPath, 'public/assets');

          fs.remove(destinationFolderPath, function() {
            fs.copy(assetsFolderPath, destinationFolderPath, function (error) {
              if (error) {
                reject(error || 'Layout path is not valid');
                return ;
              }

              resolve('Directory ' + destinationFolderPath + ' has been successfully copied.');
            });
          });

        }.bind(this));
      }.bind(this));
  },

  /**
   * Copy teams logos to laravel public folder
   *
   * @returns {*}
   * @private
   */
  _copyTeamsLogos: function () {
    return new RSVP.Promise(function(resolve, reject) {
      var assetsFolderPath = path.resolve(this.frontendRootPath, 'dist/teams-logo');

      fs.exists(assetsFolderPath, function (doesExist, error) {
        if (error || !doesExist) {
          reject(error || 'Layout path is not valid');
          return ;
        }

        resolve(assetsFolderPath);
      });
    }.bind(this)).then(function(assetsFolderPath) {
        return new RSVP.Promise(function(resolve, reject) {
          var destinationFolderPath = path.resolve(this.backendRootPath, 'public/teams-logo');

          fs.copy(assetsFolderPath, destinationFolderPath, function (error) {
            if (error) {
              reject(error || 'Layout path is not valid');
              return ;
            }

            resolve('Directory ' + destinationFolderPath + ' has been successfully copied.');
          });
        }.bind(this));
      }.bind(this));
  },

  postBuild: function (results) {

    this.ui.writeLine(chalk.underline('\n'+this.name));

    this.backendRootPath = path.resolve(__dirname, '../../../../');
    this.frontendRootPath = path.resolve(__dirname, '../../');

    return RSVP.all([
      this._copyLayout(),
      this._copyAssets(),
      this._copyTeamsLogos(),
    ]).then(function(results) {

      results.forEach(function(result) {
        this.ui.writeLine(chalk.green(result));
      }.bind(this));

    }.bind(this)).catch(function(error){
      this.ui.writeError(chalk.red('[Addon failed] ' + error));
    }.bind(this)).finally(function() {
      this.ui.writeLine('');
    }.bind(this));
  }
};
