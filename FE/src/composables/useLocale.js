import { ref, computed, watch } from 'vue'
import messages from '../i18n/index.js'

const locale = ref(localStorage.getItem('locale') || 'en')

const isRTL = computed(() => locale.value === 'fa')

const t = computed(() => messages[locale.value])

function toggleLocale() {
  locale.value = locale.value === 'en' ? 'fa' : 'en'
  localStorage.setItem('locale', locale.value)
  applyDirection()
}

function applyDirection() {
  const html = document.documentElement
  if (isRTL.value) {
    html.setAttribute('dir', 'rtl')
    html.setAttribute('lang', 'fa')
    document.body.classList.add('lang-fa')
    document.body.classList.remove('lang-en')
  } else {
    html.setAttribute('dir', 'ltr')
    html.setAttribute('lang', 'en')
    document.body.classList.add('lang-en')
    document.body.classList.remove('lang-fa')
  }
}

watch(locale, applyDirection)

export function useLocale() {
  return { locale, isRTL, t, toggleLocale, applyDirection }
}
