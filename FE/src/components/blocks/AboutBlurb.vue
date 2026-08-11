<template>
  <section id="about" class="section">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.about.subtitle }}</span>
        <h2 class="section-title">{{ t.about.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <div class="about-grid">
        <div class="about-image-col">
          <div class="avatar-wrapper">
            <div class="avatar-ring">
              <div class="avatar-inner">
                <q-img
                  v-if="data?.avatar_url"
                  :src="data.avatar_url"
                  alt="Avatar"
                  style="width: 100%; height: 100%; border-radius: 50%"
                />
                <q-icon v-else name="person" size="120px" color="primary" />
              </div>
            </div>
            <div class="avatar-badge"><q-icon name="verified" color="primary" size="24px" /></div>
            <div class="orbit orbit-1"></div>
            <div class="orbit orbit-2"></div>
          </div>
        </div>

        <div class="about-text-col">
          <h3 class="about-heading">{{ t.about.heading }}</h3>
          <div class="about-paragraph" v-html="t.about.p1"></div>
          <div class="about-paragraph" v-html="t.about.p2"></div>

          <div class="info-grid">
            <div v-for="(item, idx) in t.about.infoItems" :key="idx" class="info-item">
              <q-icon :name="item.icon" color="primary" size="20px" />
              <div>
                <div class="info-label">{{ item.label }}</div>
                <div class="info-value">{{ item.value }}</div>
              </div>
            </div>
          </div>

          <div class="languages-section">
            <div class="info-label q-mb-sm">{{ t.about.languagesLabel }}</div>
            <div class="q-gutter-sm">
              <q-chip
                v-for="lang in t.about.languages"
                :key="lang"
                color="primary"
                text-color="white"
                :label="lang"
                icon="translate"
                outline
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
})
</script>

<style scoped>
.section {
  padding: 90px 24px;
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

.about-heading {
  font-size: 1.85rem;
  font-weight: 800;
  margin: 0 0 20px;
}
.about-paragraph {
  font-size: 1.05rem;
  line-height: 1.9;
  color: #475569;
  margin-bottom: 14px;
}
.body--dark .about-paragraph {
  color: #cbd5e1;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px;
  margin: 28px 0;
}
.info-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  background: rgba(102, 126, 234, 0.05);
  border-radius: 14px;
  border: 1px solid rgba(102, 126, 234, 0.1);
  transition: transform 0.2s ease;
}
.info-item:hover {
  transform: translateX(4px);
}
.lang-fa .info-item:hover {
  transform: translateX(-4px);
}
.info-label {
  font-size: 0.75rem;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
.lang-fa .info-label {
  text-transform: none;
  letter-spacing: 0;
}
.info-value {
  font-weight: 600;
}
.languages-section {
  margin-top: 20px;
}
</style>
