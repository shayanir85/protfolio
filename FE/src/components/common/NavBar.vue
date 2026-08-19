<template>
  <q-toolbar class="navbar" :class="{ scrolled: isScrolled }">
    <div class="navbar-container">
      <div class="logo" @click="$emit('scroll-to', 'hero')">
        <div class="logo-mark">S</div>
        <span class="logo-text">Shayan</span>
      </div>

      <nav class="nav-links">
        <a
          v-for="link in navLinks"
          :key="link.id"
          :href="`#${link.id}`"
          :class="{ active: activeSection === link.id }"
          @click.prevent="$emit('scroll-to', link.id)"
        >
          {{ link.label }}
        </a>
      </nav>

      <div class="navbar-right">
        <div class="nav-actions">
          <!-- Dark mode toggle -->
          <q-btn
            round
            flat
            dense
            :icon="isDark ? 'wb_sunny' : 'nights_stay'"
            @click="$emit('toggle-dark')"
            class="theme-toggle"
            :aria-label="isDark ? t.ui.lightMode : t.ui.darkMode"
          >
            <q-tooltip anchor="bottom middle" self="top middle" :offset="[0, 10]">
              {{ isDark ? t.ui.lightMode : t.ui.darkMode }}
            </q-tooltip>
          </q-btn>

          <q-btn
            color="primary"
            :label="t.nav.hireMe"
            no-caps
            rounded
            unelevated
            @click="$emit('scroll-to', 'contact')"
            class="hire-btn"
          />
        </div>

        <q-btn
          flat
          round
          dense
          icon="menu"
          class="mobile-menu-btn"
          @click="$emit('open-mobile-menu')"
        />
      </div>
    </div>
  </q-toolbar>
</template>

<script setup>
defineProps({
  navLinks: { type: Array, default: () => [] },
  activeSection: { type: String, default: 'hero' },
  isScrolled: { type: Boolean, default: false },
  isDark: { type: Boolean, default: false },
  isRTL: { type: Boolean, default: false },
  t: { type: Object, required: true },
})

defineEmits(['toggle-dark', 'toggle-locale', 'scroll-to', 'open-mobile-menu'])
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: 16px 0;
  background: transparent;
  backdrop-filter: blur(0px);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar.scrolled {
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  padding: 10px 0;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border-bottom: 1px solid rgba(148, 163, 184, 0.2);
}

.body--dark .navbar.scrolled {
  background: rgba(15, 23, 42, 0.85);
}

.navbar-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
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

.nav-links {
  display: flex;
  gap: 8px;
}

.nav-links a {
  padding: 8px 16px;
  border-radius: 10px;
  color: #475569;
  text-decoration: none;
  font-weight: 500;
  font-size: 15px;
  transition: all 0.2s ease;
}

.body--dark .nav-links a {
  color: #cbd5e1;
}

.nav-links a:hover {
  color: #0f172a;
  background: rgba(102, 126, 234, 0.1);
}

.body--dark .nav-links a:hover {
  color: #ffffff;
  background: rgba(255, 255, 255, 0.1);
}

.nav-links a.active {
  color: white !important;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.navbar-right {
  display: flex;
  align-items: center;
  gap: 8px;
}

.nav-actions {
  display: flex;
  align-items: center;
  gap: 8px;
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

.hire-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  box-shadow: 0 4px 14px rgba(102, 126, 234, 0.4);
  font-weight: 600;
}

.hire-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.mobile-menu-btn {
  display: none;
}

@media (max-width: 768px) {
  .navbar-container {
    padding: 0 16px;
  }
  .nav-links,
  .hire-btn {
    display: none;
  }
  .mobile-menu-btn {
    display: inline-flex;
  }
}

@media (max-width: 400px) {
  .logo-text {
    font-size: 16px;
  }
  .logo-mark {
    width: 34px;
    height: 34px;
    font-size: 16px;
  }
  .lang-btn {
    padding: 2px 6px;
    font-size: 11px;
  }
}
</style>
