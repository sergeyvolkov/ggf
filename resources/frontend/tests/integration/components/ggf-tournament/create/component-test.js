import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';


moduleForComponent('ggf-tournament.create', 'Integration | Component | ggf-tournament.create', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-tournament.create}}`);

  assert.equal(this.$().text(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-tournament.create}}
      template block text
    {{/ggf-tournament.create}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
