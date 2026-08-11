<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-dark"> </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<style scoped>
.brand {
  cursor: pointer;
  font-size: 1.15rem;
  letter-spacing: 0.2px;
}

/* Desktop nav */
.desktop-nav {
  display: flex;
  align-items: center;
  gap: 8px;
}

.nav-link {
  display: flex;
  align-items: center;
  color: rgba(255, 255, 255, 0.85);
  font-size: 0.95rem;
  padding: 8px 14px;
  border-radius: 8px;
  transition:
    color 0.2s,
    background-color 0.2s;
}

.nav-link:hover {
  color: #ffffff;
  background-color: rgba(255, 255, 255, 0.12);
}

/* Mobile dropdown menu */
.mobile-menu {
  border-radius: 12px;
}
</style>
