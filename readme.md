#Integration

##Connecting ESLINT to Vue.JS project

Add this snippet in to package.json inside `fe-src` directory

```
"eslintConfig": {
  "root": true,
  "env": {
    "browser": true
    "node": true
  },
  "extends": [
    "plugin:vue/essential",
    "eslint:recommended"
  ],
  "parserOptions": {
    "parser": "babel-eslint"
  },
  "rules": {},
  "overrides": [
    {
      "files": [
        "**/__tests__/*.{j,t}s?(x)",
        "**/tests/unit/**/*.spec.{j,t}s?(x)"
      ],
      "env": {
        "mocha": true
      }
    }
  ]
}
```

#Update
Use npm to update the package.json version

``
npm version patch
``
