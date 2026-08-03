import withNuxt from './.nuxt/eslint.config.mjs'

export default withNuxt(
  // Your custom ESLint config here
  {
    rules: {
      'vue/multi-word-component-names': 'off'
    }
  }
)
