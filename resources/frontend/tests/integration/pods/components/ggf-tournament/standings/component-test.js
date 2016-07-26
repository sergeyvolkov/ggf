import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('ggf-tournament/standings', 'Integration | Component | ggf tournament/standings', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-tournament/standings}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-tournament/standings}}
      template block text
    {{/ggf-tournament/standings}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
