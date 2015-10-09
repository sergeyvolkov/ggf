import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('ggf-tournament/list', 'Integration | Component | ggf tournament/list', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-tournament/list}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-tournament/list}}
      template block text
    {{/ggf-tournament/list}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
