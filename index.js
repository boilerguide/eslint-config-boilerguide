module.exports = {
  extends: [
    'eslint:recommended',
    'plugin:vue/recommended',
    'plugin:@typescript-eslint/recommended',
  ],
  env: {
      'es6': true,
      'node': true,
      'browser': true
  },
  plugins: [
    '@typescript-eslint',
  ],
  parser: "vue-eslint-parser",
  parserOptions: {
    parser: '@typescript-eslint/parser',
  },
  rules: {
    // Eslint rule modifications
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-new-func': 'error',
    'prefer-arrow-callback': 'error',
    'arrow-body-style': ['error', 'as-needed'],
    'arrow-spacing': 'error',
    'new-cap': 'error',
    'no-eval': 'error',
    'no-implied-eval': 'error',
    'eqeqeq': 'error',
    'no-with': 'error',
    'no-warning-comments': 'error',
    'max-len': ["error", {"code": 170}],
    'no-unused-expressions': ['error', { 'allowTernary': true }],
    'no-param-reassign': 'error',
    'quote-props': ['error', 'consistent'],
    // vue rule modification
    "vue/order-in-components": ["error", {
      "order": [
        "el",
        "name",
        "key",
        "parent",
        "functional",
        ["delimiters", "comments"],
        ["components", "directives", "filters"],
        "extends",
        "mixins",
        ["provide", "inject"],
        "layout",
        "middleware",
        "validate",
        "scrollToTop",
        "transition",
        "loading",
        "inheritAttrs",
        "model",
        ["props", "propsData"],
        "setup",
        "asyncData",
        "data",
        "fetch",
        "head",
        "computed",
        "methods",
        "watch",
        "watchQuery",
        "emits",
        "LIFECYCLE_HOOKS",
        "ROUTER_GUARDS",
        ["template", "render"],
        "renderError"
      ]
    }],
    'vue/html-closing-bracket-newline': ['error', {
      'singleline': 'never',
      'multiline': 'always'
    }],
    'vue/html-closing-bracket-spacing': ['error', {
      'startTag': 'never',
      'endTag': 'never',
      'selfClosingTag': 'always'
    }],
    'vue/script-indent': ['error', 2, {
      'baseIndent': 0,
      'switchCase': 1,
      'ignores': []
    }],
    'vue/html-indent': ['error', 2, {
      "attribute": 1,
      "baseIndent": 1,
      "closeBracket": 0,
      "alignAttributesVertically": true,
      "ignores": []
    }],
    "vue/component-name-in-template-casing": ["error", "kebab-case", {
      "registeredComponentsOnly": true,
      "ignores": []
    }],

    //Disabled permanently
    'vue/require-prop-types': 'off',
    'vue/no-template-shadow': 'off',
    'vue/no-v-html': 'off',
    'vue/max-attributes-per-line': 'off',
    'vue/attribute-hyphenation': 'off',
    'prefer-destructuring': 'off',
    'import/no-unresolved': 'off',
    'no-invalid-this': 'off',
    'no-plusplus': 'off',
    'func-style': 'off',
  },
}