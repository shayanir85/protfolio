<template>
  <div class="not-found-page" :class="{ 'lang-fa': isRTL, 'lang-en': !isRTL }">
    <!-- Header bar matching main page navbar style -->
    <header class="header-bar">
      <div class="header-container">
        <div class="logo" @click="goHome">
          <div class="logo-mark">S</div>
          <span class="logo-text">Shayan</span>
        </div>

        <div class="header-actions">
          <!-- Dark Mode Toggle -->
          <q-btn
            round
            flat
            dense
            :icon="isDark ? 'wb_sunny' : 'nights_stay'"
            @click="toggleDark"
            class="theme-toggle"
            :aria-label="isDark ? t.ui.lightMode : t.ui.darkMode"
          >
            <q-tooltip anchor="bottom middle" self="top middle" :offset="[0, 10]">
              {{ isDark ? t.ui.lightMode : t.ui.darkMode }}
            </q-tooltip>
          </q-btn>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="not-found-content">
      <div class="background-glow glow-1"></div>
      <div class="background-glow glow-2"></div>

      <div class="content-card">
        <div class="error-badge">
          <q-icon name="warning" size="18px" class="q-mr-xs" />
          <span>{{ t.notFound.badge }}</span>
        </div>

        <h1 class="error-code">404</h1>

        <h2 class="error-title">{{ t.notFound.title }}</h2>
        <p class="error-description">{{ t.notFound.description }}</p>

        <!-- Auto Redirect Timer Card -->
        <div class="redirect-box">
          <div class="timer-circle">
            <q-circular-progress
              :value="(countdown / 5) * 100"
              size="64px"
              :thickness="0.15"
              color="primary"
              track-color="grey-3"
            >
              <span class="countdown-num">{{ countdown }}</span>
            </q-circular-progress>
          </div>

          <div class="timer-text">
            <span>{{ t.notFound.redirecting }} </span>
            <strong class="seconds-count">{{ countdown }} {{ t.notFound.seconds }}</strong>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <q-btn
            color="primary"
            class="go-home-btn"
            no-caps
            rounded
            unelevated
            size="lg"
            icon="home"
            :label="t.notFound.goHome"
            @click="goHome"
          />

          <q-btn
            outline
            color="primary"
            class="toggle-timer-btn"
            no-caps
            rounded
            size="lg"
            :icon="isPaused ? 'play_arrow' : 'pause'"
            :label="isPaused ? t.notFound.resumeRedirect : t.notFound.pauseRedirect"
            @click="toggleTimer"
          />
        </div>
      </div>
    </main>

    <!-- Site Footer -->
    <SiteFooter :t="t" :social-links="socialLinks" @scroll-to="goHome" />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useQuasar } from 'quasar'
import quasarLangFa from 'quasar/lang/fa-IR'
import quasarLangEn from 'quasar/lang/en-US'
import axios from 'axios'
import { useLocale } from '../composables/useLocale.js'
import SiteFooter from '../components/common/SiteFooter.vue'

const $q = useQuasar()
const router = useRouter()
const { t, isRTL, applyDirection } = useLocale()

const isDark = ref(false)
const countdown = ref(5)
const isPaused = ref(false)
const socialLinks = ref([])
let timerInterval = null

const API_BASE = 'http://127.0.0.1:8000/api'
const api = axios.create({ baseURL: API_BASE, timeout: 10000 })

function toggleDark() {
  isDark.value = !isDark.value
  $q.dark.set(isDark.value)
  localStorage.setItem('darkMode', isDark.value.toString())
}

function goHome() {
  clearInterval(timerInterval)
  router.push('/')
}

function startTimer() {
  clearInterval(timerInterval)
  timerInterval = setInterval(() => {
    if (!isPaused.value) {
      countdown.value -= 1
      if (countdown.value <= 0) {
        clearInterval(timerInterval)
        router.push('/')
      }
    }
  }, 1000)
}

function toggleTimer() {
  isPaused.value = !isPaused.value
}

async function fetchSocials() {
  try {
    const res = await api.get('/user/socials')
    const data = res.data
    if (Array.isArray(data)) socialLinks.value = data
    else if (data.data && Array.isArray(data.data)) socialLinks.value = data.data
  } catch {
    console.warn('Could not load social links')
  }
}

watch(
  isRTL,
  (rtl) => {
    $q.lang.set(rtl ? quasarLangFa : quasarLangEn)
  },
  { immediate: true },
)

watch(isDark, (val) => {
  $q.dark.set(val)
  localStorage.setItem('darkMode', val.toString())
})

onMounted(() => {
  const savedDark = localStorage.getItem('darkMode')
  if (savedDark !== null) {
    isDark.value = savedDark === 'true'
  } else {
    isDark.value = $q.dark.isActive || window.matchMedia('(prefers-color-scheme: dark)').matches
  }
  $q.dark.set(isDark.value)

  applyDirection()
  fetchSocials()
  startTimer()
})

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval)
})
</script>

<style scoped>
.not-found-page {
  font-family:
    'Inter',
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    'Segoe UI',
    Roboto,
    sans-serif;
  background: var(--bg-primary, #ffffff);
  color: var(--text-primary, #0f172a);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow-x: hidden;
  transition:
    background-color 0.4s ease,
    color 0.4s ease;
}

.not-found-page.lang-fa {
  font-family: 'IBMPlexSansArabic', 'B Nazanin', 'Nazanin', Tahoma, Arial, sans-serif;
}

.body--dark .not-found-page {
  --bg-primary: #0b1120;
  --text-primary: #f1f5f9;
}

/* Header bar styling */
.header-bar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: 16px 0;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  border-bottom: 1px solid rgba(148, 163, 184, 0.2);
}

.body--dark .header-bar {
  background: rgba(15, 23, 42, 0.85);
  border-color: rgba(255, 255, 255, 0.08);
}

.header-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  user-select: none;
}

.logo-mark {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 800;
  font-size: 20px;
  font-family: 'Inter', sans-serif !important;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  transition: transform 0.3s ease;
}

.logo:hover .logo-mark {
  transform: rotate(-8deg) scale(1.08);
}

.logo-text {
  font-size: 20px;
  font-weight: 700;
  font-family: 'Inter', sans-serif !important;
  color: #0f172a;
}

.body--dark .logo-text {
  color: #f1f5f9;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.lang-btn {
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.05em;
  border: 1.5px solid rgba(102, 126, 234, 0.4);
  border-radius: 8px;
  padding: 4px 10px;
  color: #667eea;
  font-family: 'Inter', sans-serif !important;
  transition: all 0.2s ease;
}

.lang-btn:hover {
  background: rgba(102, 126, 234, 0.1);
}

.theme-toggle {
  transition: transform 0.3s ease;
}

.theme-toggle:hover {
  transform: rotate(20deg);
}

/* Main 404 content */
.not-found-content {
  position: relative;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 120px 24px 60px;
  min-height: 80vh;
}

.background-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(100px);
  opacity: 0.35;
  pointer-events: none;
}

.glow-1 {
  width: 380px;
  height: 380px;
  background: radial-gradient(circle, #667eea 0%, rgba(102, 126, 234, 0) 70%);
  top: 15%;
  left: 20%;
}

.glow-2 {
  width: 420px;
  height: 420px;
  background: radial-gradient(circle, #764ba2 0%, rgba(118, 75, 162, 0) 70%);
  bottom: 15%;
  right: 20%;
}

.content-card {
  position: relative;
  z-index: 10;
  max-width: 650px;
  width: 100%;
  text-align: center;
  padding: 48px 36px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(148, 163, 184, 0.25);
  border-radius: 28px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
}

.body--dark .content-card {
  background: rgba(15, 23, 42, 0.75);
  border-color: rgba(255, 255, 255, 0.1);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
}

.error-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 16px;
  border-radius: 50px;
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  font-weight: 600;
  font-size: 0.9rem;
  margin-bottom: 16px;
  border: 1px solid rgba(239, 68, 68, 0.2);
}

.error-code {
  font-size: clamp(6rem, 15vw, 9rem);
  font-weight: 900;
  margin: 0;
  line-height: 1;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #a78bfa 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  letter-spacing: -2px;
}

.error-title {
  font-size: 2rem;
  font-weight: 800;
  margin: 12px 0 16px;
  color: #0f172a;
}

.body--dark .error-title {
  color: #f1f5f9;
}

.error-description {
  font-size: 1.1rem;
  color: #64748b;
  line-height: 1.6;
  margin: 0 0 32px;
}

.body--dark .error-description {
  color: #94a3b8;
}

/* Timer card */
.redirect-box {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  padding: 16px 24px;
  background: rgba(102, 126, 234, 0.08);
  border: 1px solid rgba(102, 126, 234, 0.2);
  border-radius: 16px;
  margin-bottom: 36px;
}

.body--dark .redirect-box {
  background: rgba(102, 126, 234, 0.15);
  border-color: rgba(102, 126, 234, 0.3);
}

.countdown-num {
  font-weight: 800;
  font-size: 1.3rem;
  color: #667eea;
}

.body--dark .countdown-num {
  color: #a78bfa;
}

.timer-text {
  font-size: 1rem;
  color: #334155;
}

.body--dark .timer-text {
  color: #cbd5e1;
}

.seconds-count {
  color: #667eea;
  font-weight: 700;
}

.body--dark .seconds-count {
  color: #a78bfa;
}

/* Action buttons */
.action-buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

.go-home-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  font-weight: 700;
  padding: 10px 28px;
  transition: all 0.3s ease;
}

.go-home-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
}

.toggle-timer-btn {
  font-weight: 600;
  padding: 10px 24px;
}

@media (max-width: 600px) {
  .content-card {
    padding: 32px 20px;
  }

  .redirect-box {
    flex-direction: column;
    text-align: center;
    gap: 8px;
  }

  .action-buttons {
    flex-direction: column;
    width: 100%;
  }

  .go-home-btn,
  .toggle-timer-btn {
    width: 100%;
  }
}
</style>
