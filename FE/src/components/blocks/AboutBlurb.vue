<template>
  <section v-if="hasData" id="about" class="section">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ displaySubtitle }}</span>
        <h2 class="section-title">{{ displayTitle }}</h2>
        <div class="section-divider"></div>
      </div>

      <div class="about-grid">
        <div class="about-image-col">
          <div class="avatar-wrapper">
            <div class="avatar-ring">
              <div class="avatar-inner">
                <q-img
                  v-if="avatarSrc"
                  :src="avatarSrc"
                  alt="Avatar"
                  fit="cover"
                  class="avatar-image"
                >
                  <template #error>
                    <div class="full-width full-height flex flex-center">
                      <q-icon name="person" size="100px" color="primary" />
                    </div>
                  </template>
                </q-img>
                <q-icon v-else name="person" size="120px" color="primary" />
              </div>
            </div>
            <div class="avatar-badge"><q-icon name="verified" color="primary" size="24px" /></div>
            <div class="orbit orbit-1"></div>
            <div class="orbit orbit-2"></div>
          </div>
        </div>

        <div class="about-text-col">
          <div v-if="aboutData?.content" class="rich-html-content" v-html="aboutData.content"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  aboutData: { type: Object, default: null },
})

const hasData = computed(() => {
  return Boolean(
    props.aboutData &&
      (props.aboutData.content ||
        props.aboutData.title ||
        props.aboutData.avatar_url),
  )
})

const displayTitle = computed(() => {
  return props.aboutData?.title || 'درباره من'
})

const displaySubtitle = computed(() => {
  return props.aboutData?.subtitle || 'بیشتر بشناسید'
})

const avatarSrc = computed(() => {
  const url = props.aboutData?.avatar_url
  if (!url) return null

  // If already an absolute URL with port or external domain
  if (url.startsWith('http://') || url.startsWith('https://')) {
    // If backend generated URL with 127.0.0.1 without port 8000 while local dev runs on 8000
    if (url.startsWith('http://127.0.0.1/storage/') || url.startsWith('http://localhost/storage/')) {
      return url.replace('http://127.0.0.1/storage/', 'http://127.0.0.1:8000/storage/').replace('http://localhost/storage/', 'http://127.0.0.1:8000/storage/')
    }
    return url
  }

  // If relative path like /storage/avatars/xxx.png or avatars/xxx.png
  const cleanPath = url.startsWith('/') ? url : `/${url}`
  return `http://127.0.0.1:8000${cleanPath}`
})
</script>

<style scoped>
.section {
  padding: 90px 24px;
}
@media (max-width: 768px) {
  .section {
    padding: 50px 16px;
  }
}
.section-container {
  max-width: 1200px;
  margin: 0 auto;
}
.section-header {
  text-align: center;
  margin-bottom: 60px;
}
.section-subtitle {
  display: inline-block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #667eea;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  margin-bottom: 12px;
}
.lang-fa .section-subtitle {
  text-transform: none;
  letter-spacing: 0;
}
.section-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  margin: 0 0 20px;
}
.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  margin: 0 auto;
  border-radius: 2px;
}

.about-grid {
  display: grid;
  grid-template-columns: 1fr 1.5fr;
  gap: 60px;
  align-items: center;
}
@media (max-width: 768px) {
  .about-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
}

.avatar-wrapper {
  position: relative;
  width: 300px;
  height: 300px;
  margin: 0 auto;
}
@media (max-width: 480px) {
  .avatar-wrapper {
    width: 220px;
    height: 220px;
  }
}
.avatar-ring {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  padding: 6px;
  background: linear-gradient(135deg, #667eea, #764ba2);
}
.avatar-inner {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.avatar-image {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}
.body--dark .avatar-inner {
  background: #0f172a;
}
.avatar-badge {
  position: absolute;
  bottom: 15px;
  right: 15px;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
.body--dark .avatar-badge {
  background: #0f172a;
}
.orbit {
  position: absolute;
  border: 1px dashed rgba(102, 126, 234, 0.3);
  border-radius: 50%;
  animation: orbit 20s linear infinite;
}
.orbit-1 {
  inset: -15px;
}
.orbit-2 {
  inset: -30px;
  animation-duration: 30s;
  animation-direction: reverse;
}
@keyframes orbit {
  to {
    transform: rotate(360deg);
  }
}

.about-text-col {
  display: flex;
  flex-direction: column;
}

.rich-html-content :deep(h1),
.rich-html-content :deep(h2),
.rich-html-content :deep(h3),
.rich-html-content :deep(h4) {
  font-weight: 800;
  margin-top: 20px;
  margin-bottom: 14px;
  line-height: 1.35;
}

.rich-html-content :deep(h1) {
  font-size: 2rem;
}
.rich-html-content :deep(h2) {
  font-size: 1.65rem;
}
.rich-html-content :deep(h3) {
  font-size: 1.35rem;
}

.rich-html-content :deep(p) {
  font-size: 1.05rem;
  line-height: 1.9;
  color: #475569;
  margin-bottom: 14px;
}

.body--dark .rich-html-content :deep(p) {
  color: #cbd5e1;
}

.rich-html-content :deep(ul),
.rich-html-content :deep(ol) {
  padding-right: 24px;
  margin-bottom: 16px;
  line-height: 1.85;
  color: #475569;
}

.body--dark .rich-html-content :deep(ul),
.body--dark .rich-html-content :deep(ol) {
  color: #cbd5e1;
}

.rich-html-content :deep(li) {
  margin-bottom: 6px;
}

.rich-html-content :deep(blockquote) {
  margin: 16px 0;
  padding: 12px 20px;
  border-right: 4px solid #667eea;
  background: rgba(102, 126, 234, 0.06);
  border-radius: 8px;
  font-style: italic;
}

.rich-html-content :deep(a) {
  color: #667eea;
  text-decoration: underline;
  font-weight: 600;
}

.rich-html-content :deep(code) {
  background: rgba(102, 126, 234, 0.1);
  padding: 2px 6px;
  border-radius: 4px;
  font-family: monospace;
  font-size: 0.9em;
  color: #667eea;
}

.rich-html-content :deep(pre) {
  background: #1e293b;
  color: #f8fafc;
  padding: 16px;
  border-radius: 12px;
  overflow-x: auto;
  margin-bottom: 16px;
}

.rich-html-content :deep(pre code) {
  background: transparent;
  padding: 0;
  color: inherit;
}
</style>
