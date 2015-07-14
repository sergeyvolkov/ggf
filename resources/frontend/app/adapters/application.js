import DS from 'ember-data';
import config from '../config/environment';

export default DS.RESTAdapter.extend({
  namespace: config.APP.namespace,
  host: config.APP.host,
  shouldReloadAll: function() {
    return true;
  },
  shouldBackgroundReloadAll: function() {
    return false;
  }
});
