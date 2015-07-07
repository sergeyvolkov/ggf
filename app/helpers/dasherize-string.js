import Ember from 'ember';

export function dasherizeString(params) {
  let str = params[0];
  return str.dasherize();
}

export default Ember.HTMLBars.makeBoundHelper(dasherizeString);
