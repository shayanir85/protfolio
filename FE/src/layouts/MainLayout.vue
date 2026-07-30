<template>
  <q-layout view="lHh Lpr lFf">
    <q-header class="portfolio-header" elevated>
      <q-toolbar class="portfolio-toolbar">
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
          class="portfolio-header__menu-btn"
        />

        <q-toolbar-title class="portfolio-header__title">
          <span class="portfolio-header__logo">Portfolio</span>
        </q-toolbar-title>

        <div class="portfolio-header__nav">
          <q-btn
            flat
            round
            icon="dark_mode"
            @click="toggleDark"
            class="portfolio-header__icon-btn"
          />
          <a
            href="https://github.com"
            target="_blank"
            rel="noopener noreferrer"
            class="portfolio-header__icon-btn"
          >
            <q-icon name="fab fa-github" />
          </a>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered class="portfolio-drawer">
      <q-list class="portfolio-drawer__list">
        <q-item-label header class="portfolio-drawer__header"> Navigation </q-item-label>

        <q-item
          v-for="link in navLinks"
          :key="link.label"
          clickable
          v-ripple
          class="portfolio-drawer__item"
          :to="link.to"
        >
          <q-item-section avatar>
            <q-icon :name="link.icon" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ link.label }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container class="portfolio-page-container">
      <router-view />
    </q-page-container>

    <q-footer class="portfolio-footer">
      <q-toolbar class="portfolio-toolbar">
        <q-toolbar-title class="portfolio-footer__text">
          © {{ new Date().getFullYear() }} Portfolio. Built with Laravel & Quasar.
        </q-toolbar-title>
        <div class="portfolio-footer__links">
          <a href="mailto:contact@example.com" class="portfolio-footer__link">
            <q-icon name="email" />
          </a>
          <a
            href="https://github.com"
            target="_blank"
            rel="noopener noreferrer"
            class="portfolio-footer__link"
          >
            <q-icon name="fab fa-github" />
          </a>
        </div>
      </q-toolbar>
    </q-footer>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useQuasar } from 'quasar'

const $q = useQuasar()

const leftDrawerOpen = ref(false)
const isDark = ref(false)

const navLinks = [
  { label: 'Home', icon: 'home', to: '/' },
  { label: 'About', icon: 'person', to: '/#about' },
  { label: 'Skills', icon: 'psychology', to: '/#skills' },
  { label: 'Experience', icon: 'work', to: '/#experience' },
  { label: 'Projects', icon: 'folder', to: '/#projects' },
  { label: 'Contact', icon: 'mail', to: '/#contact' },
]

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value
}

function toggleDark() {
  isDark.value = !isDark.value
  $q.dark.set(isDark.value)
}
</script>

<style scoped>
.portfolio-header {
  background: rgba(15, 23, 42, 0.9) !important;
  backdrop-filter: blur(12px);
  border-bottom: 1px solid rgba(148, 163, 184, 0.1);
}

.portfolio-toolbar {
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
  padding: 0 1rem;
}

.portfolio-header__title {
  font-weight: 700;
}

.portfolio-header__logo {
  background: linear-gradient(135deg, #818cf8, #c084fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.portfolio-header__nav {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.portfolio-header__icon-btn {
  color: #94a3b8;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.portfolio-header__icon-btn:hover {
  color: #818cf8;
  background: rgba(129, 140, 248, 0.1);
}

.portfolio-drawer {
  background: #0f172a !important;
  border-right: 1px solid rgba(148, 163, 184, 0.1) !important;
}

.portfolio-drawer__list {
  padding: 1rem;
}

.portfolio-drawer__header {
  color: #64748b;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.portfolio-drawer__item {
  border-radius: 0.75rem;
  margin-bottom: 0.25rem;
  color: #94a3b8;
  transition: all 0.3s ease;
}

.portfolio-drawer__item:hover {
  background: rgba(129, 140, 248, 0.1);
  color: #818cf8;
}

.portfolio-page-container {
  background: #0f172a;
}

.portfolio-footer {
  background: rgba(15, 23, 42, 0.9) !important;
  backdrop-filter: blur(12px);
  border-top: 1px solid rgba(148, 163, 184, 0.1);
}

.portfolio-footer__text {
  color: #64748b;
  font-size: 0.875rem;
}

.portfolio-footer__links {
  display: flex;
  gap: 0.5rem;
}

.portfolio-footer__link {
  color: #64748b;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.portfolio-footer__link:hover {
  color: #818cf8;
  background: rgba(129, 140, 248, 0.1);
}
</style>
