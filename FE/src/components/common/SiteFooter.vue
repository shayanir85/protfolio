<template>
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-top">
        <div class="footer-brand">
          <div class="logo" @click="$emit('scroll-to', 'hero')">
            <div class="logo-mark">S</div>
            <span class="logo-text">Shayan</span>
          </div>
          <p class="footer-tagline">{{ t.footer.tagline }}</p>
        </div>

        <div class="footer-socials" v-if="socialLinks && socialLinks.length > 0">
          <q-btn
            v-for="(link, index) in socialLinks"
            :key="index"
            round
            flat
            :icon="getSocialIcon(link.social_media_name)"
            :href="link.social_link"
            target="_blank"
            class="social-btn"
          />
        </div>
      </div>

      <q-separator class="footer-separator" />

      <div class="footer-bottom">
        <span>{{ t.footer.built }} </span>
        <span class="gradient-text"><bdi class="en-inline">Quasar & Vue 3</bdi></span>
        <span>
          • © {{ new Date().getFullYear() }} <bdi class="en-inline">Shayan Iranpour</bdi>.
          {{ t.footer.rights }}</span
        >
      </div>
    </div>
  </footer>
</template>

<script setup>
defineProps({
  t: { type: Object, required: true },
  socialLinks: { type: Array, default: () => [] },
})

defineEmits(['scroll-to'])

function getSocialIcon(platform) {
  const icons = {
    github: 'fab fa-github',
    linkedin: 'fab fa-linkedin',
    instagram: 'fab fa-instagram',
    twitter: 'fab fa-twitter',
    facebook: 'fab fa-facebook',
    youtube: 'fab fa-youtube',
    telegram: 'fab fa-telegram',
    whatsapp: 'fab fa-whatsapp',
    email: 'email',
    website: 'language',
  }
  return icons[(platform || '').toLowerCase()] || 'link'
}
</script>

<style scoped>
.site-footer {
  background: #f8fafc;
  border-top: 1px solid rgba(148, 163, 184, 0.2);
  padding: 56px 24px 28px;
  transition: all 0.4s ease;
}
.body--dark .site-footer {
  background: #0b1120;
  border-color: rgba(255, 255, 255, 0.08);
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
}

.footer-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 30px;
  margin-bottom: 36px;
}

.footer-brand {
  max-width: 420px;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  margin-bottom: 12px;
}
.logo-mark {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 800;
  font-size: 18px;
  font-family: 'Inter', sans-serif !important;
}
.logo-text {
  font-size: 18px;
  font-weight: 700;
  color: #0f172a;
  font-family: 'Inter', sans-serif !important;
}
.body--dark .logo-text {
  color: #f1f5f9;
}

.footer-tagline {
  color: #64748b;
  font-size: 0.95rem;
  margin: 0;
  line-height: 1.6;
}

.footer-socials {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.social-btn {
  color: #64748b;
  transition: all 0.2s ease;
}
.social-btn:hover {
  color: #667eea;
  transform: translateY(-2px);
}

.footer-separator {
  opacity: 0.15;
  margin-bottom: 22px;
}

.footer-bottom {
  direction: rtl;
  text-align: center;
  font-size: 0.9rem;
  color: #94a3b8;
}
.gradient-text {
  background: linear-gradient(135deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-weight: 600;
}
</style>
