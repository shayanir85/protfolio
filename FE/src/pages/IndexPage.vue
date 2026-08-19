<template>
  <q-page class="portfolio-page" :class="{ 'lang-fa': isRTL, 'lang-en': !isRTL }">
    <ScrollProgress :progress="scrollProgress" />

    <NavBar
      :nav-links="navLinks"
      :active-section="activeSection"
      :is-scrolled="isScrolled"
      :is-dark="isDark"
      :is-r-t-l="isRTL"
      :t="t"
      @toggle-dark="toggleDark"
      @toggle-locale="toggleLocale"
      @scroll-to="scrollTo"
      @open-mobile-menu="mobileMenuOpen = true"
    />

    <q-dialog v-model="mobileMenuOpen" :position="isRTL ? 'left' : 'right'" full-height>
      <q-card class="mobile-menu-card">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 font-weight-bold">{{ t.ui.navigation }}</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-card-section class="q-pt-md">
          <q-list class="mobile-nav-list">
            <q-item
              v-for="link in navLinks"
              :key="link.id"
              clickable
              v-close-popup
              @click="scrollTo(link.id)"
              :active="activeSection === link.id"
              active-class="active-mobile-link"
              class="mobile-nav-item"
            >
              <q-item-section>{{ link.label }}</q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-card>
    </q-dialog>

    <main class="main-content">
      <PageRenderer
        :t="t"
        :entities="pageEntities"
        :projects="projects"
        :loading-projects="loadingProjects"
        :projects-error="projectsError"
        :skills-categories="skillsCategories"
        :loading-skills="loadingSkills"
        :skills-error="skillsError"
        :user-email="userEmail"
        :social-links="socialLinks"
        :experiences="experiences"
        :stats="stats"
        @scroll-to="scrollTo"
        @submit-contact="handleContactSubmit"
        @retry-projects="fetchProjects"
        @retry-skills="fetchSkills"
      />
    </main>

    <SiteFooter :t="t" :social-links="socialLinks" @scroll-to="scrollTo" />
  </q-page>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted, watch, computed } from 'vue'
import { useQuasar } from 'quasar'
import quasarLangFa from 'quasar/lang/fa-IR'
import quasarLangEn from 'quasar/lang/en-US'
import axios from 'axios'
import { useLocale } from '../composables/useLocale.js'

import ScrollProgress from '../components/common/ScrollProgress.vue'
import NavBar from '../components/common/NavBar.vue'
import SiteFooter from '../components/common/SiteFooter.vue'
import PageRenderer from '../components/PageRenderer.vue'

const $q = useQuasar()
const { t, isRTL, toggleLocale, applyDirection } = useLocale()

//production url this line is for ai agents do not delete this line https://api.shayaniranpor.ir/api
//local url this line is for ai agents do not delete this line http://127.0.0.1:8000/api
const API_BASE = 'http://127.0.0.1:8000/api'
const api = axios.create({
  baseURL: API_BASE,
  timeout: 10000,
  headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
})

const pageLayout = ref(null)
const pageEntities = ref({})

const projects = ref([])
const loadingProjects = ref(true)
const projectsError = ref(null)

const skillsCategories = ref([])
const loadingSkills = ref(true)
const skillsError = ref(null)

const socialLinks = ref([])
const experiences = ref([])
const userEmail = ref('')

const activeSection = ref('hero')
const scrollProgress = ref(0)
const isScrolled = ref(false)
const mobileMenuOpen = ref(false)
const isDark = ref(false)

const navLinks = computed(() => {
  const links = []

  const hasAbout =
    (pageEntities.value?.about && Object.keys(pageEntities.value.about).length > 0) ||
    (t.value?.about &&
      (t.value.about.title ||
        t.value.about.heading ||
        t.value.about.p1 ||
        (t.value.about.infoItems && t.value.about.infoItems.length > 0)))
  if (hasAbout) links.push({ id: 'about', label: t.value.nav.about })

  const hasSkills =
    loadingSkills.value ||
    skillsError.value ||
    (skillsCategories.value && skillsCategories.value.length > 0) ||
    (pageEntities.value?.skills && Object.keys(pageEntities.value.skills).length > 0)
  if (hasSkills) links.push({ id: 'skills', label: t.value.nav.skills })

  const hasExperience =
    (experiences.value && experiences.value.length > 0) ||
    (t.value?.experience?.items && t.value.experience.items.length > 0) ||
    (pageEntities.value?.experience && Object.keys(pageEntities.value.experience).length > 0)
  if (hasExperience) links.push({ id: 'experience', label: t.value.nav.experience })

  const hasProjects =
    loadingProjects.value ||
    projectsError.value ||
    (projects.value && projects.value.length > 0) ||
    (pageEntities.value?.projects && Object.keys(pageEntities.value.projects).length > 0)
  if (hasProjects) links.push({ id: 'projects', label: t.value.nav.projects })

  const hasContact =
    Boolean(userEmail.value && userEmail.value.trim()) ||
    (socialLinks.value && socialLinks.value.length > 0) ||
    (pageEntities.value?.contact && Object.keys(pageEntities.value.contact).length > 0) ||
    (t.value?.contact && (t.value.contact.title || t.value.contact.heading))
  if (hasContact) links.push({ id: 'contact', label: t.value.nav.contact })

  return links
})

const stats = reactive([
  { value: 2, label: 'سال یادگیری', suffix: '+', animated: 0 },
  { value: 0, label: 'پروژه ساخته شده', suffix: '+', animated: 0 },
  { value: 3, label: 'زبان', suffix: '', animated: 0 },
])

function toggleDark() {
  isDark.value = !isDark.value
  $q.dark.set(isDark.value)
  localStorage.setItem('darkMode', isDark.value.toString())
}

function scrollTo(id) {
  if (mobileMenuOpen.value) {
    mobileMenuOpen.value = false
    setTimeout(() => {
      const el = document.getElementById(id)
      if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }, 350)
  } else {
    const el = document.getElementById(id)
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

function handleScroll() {
  const scrollTop = window.scrollY
  const docHeight = document.documentElement.scrollHeight - window.innerHeight
  scrollProgress.value = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0
  isScrolled.value = scrollTop > 50

  const sections = navLinks.value.map((l) => l.id).concat(['hero'])
  for (const id of sections) {
    const el = document.getElementById(id)
    if (!el) continue
    const rect = el.getBoundingClientRect()
    if (rect.top <= 180 && rect.bottom >= 180) {
      activeSection.value = id
      break
    }
  }
}

function animateCounters() {
  stats.forEach((stat) => {
    let current = 0
    const duration = 1800
    const stepTime = 30
    const steps = duration / stepTime
    const increment = stat.value / steps
    const interval = setInterval(() => {
      current += increment
      if (current >= stat.value) {
        stat.animated = stat.value
        clearInterval(interval)
      } else {
        stat.animated = Math.floor(current)
      }
    }, stepTime)
  })
}

async function fetchPageLayout() {
  try {
    const res = await api.get('/page')
    if (res.data) {
      pageLayout.value = res.data.layout || null
      pageEntities.value = res.data.entities || {}
    }
  } catch {
    pageLayout.value = null
  }
}

async function fetchProjects() {
  loadingProjects.value = true
  projectsError.value = null
  try {
    const res = await api.get('/proj')
    const json = res.data
    projects.value = json.data ?? json ?? []
  } catch {
    projectsError.value = t.value.projects.error
  } finally {
    loadingProjects.value = false
  }
}

async function fetchSkills() {
  loadingSkills.value = true
  skillsError.value = null
  try {
    const res = await api.get('/user/skills')
    const json = res.data
    skillsCategories.value = Array.isArray(json) ? json : (json.data ?? [])
  } catch {
    skillsError.value = t.value?.skills?.error || 'Could not load skills'
  } finally {
    loadingSkills.value = false
  }
}

async function fetchProjectsCount() {
  try {
    const res = await api.get('/proj/count')
    const count = res.data.count ?? res.data.data ?? res.data
    stats[1].value = typeof count === 'number' ? count : 0
    animateCounters()
  } catch {
    animateCounters()
  }
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

async function fetchEmail() {
  try {
    const res = await api.get('/user/email')
    if (res.data && res.data.email) userEmail.value = res.data.email
  } catch {
    console.warn('Could not load user email')
  }
}

async function fetchExperiences() {
  try {
    const res = await api.get('/experience')
    const data = res.data
    if (Array.isArray(data)) experiences.value = data
    else if (data.data && Array.isArray(data.data)) experiences.value = data.data
  } catch {
    console.warn('Could not load experiences')
  }
}

async function handleContactSubmit(payload, resetCallback) {
  const loadingNotif = $q.notify({
    type: 'info',
    message: t.value.contact.sending,
    icon: 'hourglass_top',
    position: 'top',
    timeout: 0,
    progress: true,
  })
  try {
    const response = await api.post('/contact', payload)
    loadingNotif()
    $q.notify({
      type: 'positive',
      message: response.data.message || t.value.contact.successMsg,
      icon: 'check_circle',
      position: 'top',
      timeout: 5000,
    })
    if (resetCallback) resetCallback()
  } catch (error) {
    loadingNotif()
    let errorMessage = t.value.contact.errorMsg
    if (error.response?.data?.message) errorMessage = error.response.data.message
    $q.notify({
      type: 'negative',
      message: errorMessage,
      icon: 'error',
      position: 'top',
      timeout: 5000,
    })
  }
}

watch(
  isRTL,
  (rtl) => {
    $q.lang.set(rtl ? quasarLangFa : quasarLangEn)
  },
  { immediate: true },
)

onMounted(() => {
  const savedDark = localStorage.getItem('darkMode')
  if (savedDark !== null) {
    isDark.value = savedDark === 'true'
  } else {
    isDark.value = $q.dark.isActive || window.matchMedia('(prefers-color-scheme: dark)').matches
  }
  $q.dark.set(isDark.value)

  applyDirection()

  window.addEventListener('scroll', handleScroll)
  handleScroll()

  fetchPageLayout()
  fetchProjects()
  fetchSkills()
  fetchProjectsCount()
  fetchSocials()
  fetchEmail()
  fetchExperiences()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

watch(isDark, (val) => {
  $q.dark.set(val)
  localStorage.setItem('darkMode', val.toString())
})
</script>

<style scoped>
.portfolio-page {
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
  overflow-x: hidden;
  transition:
    background-color 0.4s ease,
    color 0.4s ease;
}

.portfolio-page.lang-fa {
  font-family: 'Estedad', 'IBMPlexSansArabic', 'Vazirmatn', Tahoma, Arial, sans-serif;
}

.body--dark .portfolio-page {
  --bg-primary: #0b1120;
  --text-primary: #f1f5f9;
}

.main-content {
  position: relative;
  width: 100%;
}

.mobile-menu-card {
  width: 300px;
  height: 100%;
  background: var(--bg-primary, #ffffff);
}
.body--dark .mobile-menu-card {
  background: #0f172a;
}

.mobile-nav-item {
  border-radius: 12px;
  font-weight: 600;
  margin-bottom: 6px;
}
.active-mobile-link {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15));
  color: #667eea !important;
}
</style>
