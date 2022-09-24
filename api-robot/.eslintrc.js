module.exports = {
  env: {
    browser: true,
    es2021: true
  },
  extends: [
    'standard'
  ],
  parser: '@typescript-eslint/parser',
  parserOptions: {
    ecmaVersion: 13
  },
  plugins: [
    '@typescript-eslint'
  ],
  rules: {
    camelcase: [2, { properties: 'never' }]
  }
}
