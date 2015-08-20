import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';


moduleForComponent('ggf-reveal-menu', 'Integration | Component | ggf reveal menu', {
  integration: true
});

test('it renders', function(assert) {
  assert.expect(2);

  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{ggf-reveal-menu}}`);

  assert.equal(this.$().text(), '');

  // Template block usage:
  this.render(hbs`
    {{#ggf-reveal-menu}}
      template block text
    {{/ggf-reveal-menu}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
