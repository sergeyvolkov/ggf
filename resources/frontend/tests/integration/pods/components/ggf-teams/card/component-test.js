import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';


moduleForComponent('ggf-teams.card', 'Integration | Component | ggf teams.card', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-teams.card}}`);

  assert.equal(this.$().text(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-teams.card}}
      template block text
    {{/ggf-teams.card}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
