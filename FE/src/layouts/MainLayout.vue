<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated class="bg-dark">
      <q-toolbar>
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="toggleLeftDrawer" class="lt-md" />

        <q-toolbar-title class="text-weight-bold">
          Shayan Iranpour
        </q-toolbar-title>

        <div class="row items-center q-gutter-md gt-sm">
          <a v-for="link in navLinks" :key="link.label" :href="link.href"
            class="text-white text-decoration-none cursor-pointer nav-link">
            {{ link.label }}
          </a>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header class="text-weight-bold text-h6">Navigation</q-item-label>
        <q-item v-for="link in navLinks" :key="link.label" clickable v-close-popup @click="scrollTo(link.href)">
          <q-item-section avatar>
            <q-icon :name="link.icon" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ link.label }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'

const navLinks = [
  { label: 'About', href: '#about', icon: 'person' },
  { label: 'Experience', href: '#experience', icon: 'work' },
  { label: 'Projects', href: '#projects', icon: 'folder' },
  { label: 'Contact', href: '#contact', icon: 'mail' },
]

const leftDrawerOpen = ref(false)

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value
}

function scrollTo(href) {
  const el = document.querySelector(href)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>

<style scoped>
.nav-link {
  transition: opacity 0.2s;
  font-size: 0.95rem;
}
.nav-link:hover {
  opacity: 0.8;
}
</style>
