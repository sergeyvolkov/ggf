import Ember from 'ember';

const {computed, Component} = Ember;

export default Component.extend({
  homeScore: null,
  awayScore: null,
  status: null,
  editState: false,

  classNameBindings: [':col', ':s3'],

  score: computed('homeScore', 'awayScore', 'status', function() {
    const homeScore = (this.get('status') !== 'not_started') ? this.get('homeScore') : '-';
    const awayScore = (this.get('status') !== 'not_started') ? this.get('awayScore') : '-';

    return `${homeScore} : ${awayScore}`;
  }),

  click() {
    this.sendAction('toggle');
  }
});