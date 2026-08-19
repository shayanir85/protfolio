import { ref, computed } from 'vue'
import messages from '../i18n/index.js'

const locale = ref('fa')

const isRTL = computed(() => true)

const t = computed(() => messages.fa)

function toggleLocale() {
  // Front-end is exclusively Persian
  locale.value = 'fa'
  applyDirection()
}

function applyDirection() {
  const html = document.documentElement
  html.setAttribute('dir', 'rtl')
  html.setAttribute('lang', 'fa')
  document.body.classList.add('lang-fa')
  document.body.classList.remove('lang-en')
}

export function useLocale() {
  return { locale, isRTL, t, toggleLocale, applyDirection }
}
