import Ember from 'ember';

export function lowerCase(params) {
  let str = params[0];
  return str.toLowerCase();
}

export default Ember.HTMLBars.makeBoundHelper(lowerCase);
