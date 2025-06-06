/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
  root: true,
  env: {
    browser: true,
    es6: true,
    node: true
  },
  extends: [
    'standard',
    'plugin:vue/vue3-recommended',
    'plugin:prettier/recommended',
    'plugin:vuetify/recommended',
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    '@vue/eslint-config-prettier',
    'prettier'
  ],
  plugins: ['prettier', 'vue', 'vuetify'],
  parserOptions: {
    ecmaVersion: 'latest'
  },
  rules: {
    'vue/require-default-prop': 'off',
    'vue/multi-word-component-names': 'off',
    'no-undef': 'off',
    indent: ['error', 2]
  },
  globals: {
    // sweetalert2
    swToast: true,
    swDeleteConfirm: true,
    swDeleteQuestion: true,
    // metadata
    setMetadata: true,
    // Formaters
    formatDate: true,
    formatCount: true,
    avatarText: true,
    kFormatter: true,
    formatDateToMonthShort: true,
    prefixWithPlus: true,
    // Helpers
    isEmpty: true,
    isNotEmpty: true,
    isNullOrUndefined: true,
    isEmptyArray: true,
    isObject: true,
    isArrayOfObjects: true,
    isToday: true,
    sleep: true,
    permitDelete: true,
    permitEdit: true,
    permitList: true,
    permitCreate: true,
    permitShow: true,
    can: true,
    stringLimit: true,
    // Validators
    requiredValidator: true,
    emailValidator: true,
    passwordValidator: true,
    confirmedValidator: true,
    betweenValidator: true,
    integerValidator: true,
    regexValidator: true,
    alphaValidator: true,
    urlValidator: true,
    lengthValidator: true,
    alphaDashValidator: true,
    isValidLength: true,
    cnpjValidator: true,
    cpfValidator: true,
    phoneValidator: true,
    dateValidator: true,
    cepValidator: true,
    // Headers
    apiHeaders: true,
    // Pagination
    pagedArray: true,
    // General
    nextTick: true,
    defineComponent: true,
    defineAsyncComponent: true,
    defineCustomElement: true,
    // Vue Reactivity: Core
    ref: true,
    computed: true,
    reactive: true,
    readonly: true,
    watchEffect: true,
    watchPostEffect: true,
    watchSyncEffect: true,
    watch: true,
    // Vue Reactivity: Utilities
    isRef: true,
    unref: true,
    toRef: true,
    toRefs: true,
    isProxy: true,
    isReactive: true,
    isReadonly: true,
    // Vue Reactivity: Advanced
    shallowRef: true,
    triggerRef: true,
    customRef: true,
    shallowReactive: true,
    shallowReadonly: true,
    toRaw: true,
    markRaw: true,
    effectScope: true,
    getCurrentScope: true,
    onScopeDispose: true,
    // Vue Lifecycle Hooks
    onMounted: true,
    onUpdated: true,
    onUnmounted: true,
    onBeforeMount: true,
    onBeforeUpdate: true,
    onBeforeUnmount: true,
    onErrorCaptured: true,
    onRenderTracked: true,
    onRenderTriggered: true,
    onActivated: true,
    onDeactivated: true,
    onServerPrefetch: true,
    // Vue Dependency Injection
    provide: true,
    inject: true,
    // Vue <script setup>
    defineProps: true,
    defineEmits: true,
    useAttrs: true,
    useSlots: true,
    useFocus: true,
    defineExpose: true,
    // Inertia
    router: true,
    useForm: true,
    usePage: true,
    route: true,
    // Pinia
    defineStore: true,
    storeToRefs: true,
    // Vuetify,
    vuetify: true,
    Ziggy: 'writable' // ?? i dont know why it is not defined
  },
  ignorePatterns: ['node_modules/**/*', 'public/**/*', 'resources/styles/**/*', 'vendor/**/*']
}
