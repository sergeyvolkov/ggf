import DS from 'ember-data';
import config from '../config/environment';
import ApplicationAdapter from './application';

export default ApplicationAdapter.extend({
  //modelName: 'teams',
  //
  //findQuery: function (store, type, query) {
  //  let url = this.buildURL(this.modelName, null, null, "findQuery", query);
  //
  //  if (this.sortQueryParams) {
  //    query = this.sortQueryParams(query);
  //  }
  //
  //  return this.ajax(url, "GET", { data: query });
  //}
});
