<template>
  <section id="hero" class="hero-section">
    <div class="hero-bg">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>
      <div class="blob blob-3"></div>
      <div class="grid-overlay"></div>
    </div>

    <div class="hero-content">
      <q-chip
        class="hero-chip"
        color="primary"
        text-color="white"
        icon="auto_awesome"
        outline
        dense
      >
        {{ t.hero.badge }}
      </q-chip>

      <h1 class="hero-title">
        {{ t.hero.greeting }} <span class="gradient-text">{{ t.hero.name }}</span>
      </h1>

      <div class="typewriter-container">
        <span class="typewriter-prefix">{{ t.hero.prefix }}</span>
        <span class="typewriter-text">{{ displayedText }}</span>
        <span class="typewriter-cursor">|</span>
      </div>

      <p class="hero-description" v-html="t.hero.description"></p>

      <div class="hero-actions">
        <q-btn
          color="primary"
          :label="t.hero.viewWork"
          no-caps
          rounded
          unelevated
          icon-right="arrow_forward"
          @click="$emit('scroll-to', 'projects')"
          size="lg"
          class="btn-primary-grad"
        />
        <q-btn
          outline
          color="primary"
          :label="t.hero.getInTouch"
          no-caps
          rounded
          size="lg"
          icon="mail"
          @click="$emit('scroll-to', 'contact')"
        />
      </div>

      <div class="stats-row" v-if="stats && stats.length > 0">
        <div
          v-for="(stat, idx) in stats"
          :key="idx"
          class="stat-card"
          :style="{ animationDelay: idx * 0.1 + 's' }"
        >
          <div class="stat-value">
            <span>{{ stat.animated !== undefined ? stat.animated : stat.value }}</span>
            <span class="stat-suffix">{{ stat.suffix }}</span>
          </div>
          <div class="stat-label">{{ t.stats[idx]?.label || stat.label }}</div>
        </div>
      </div>
    </div>

    <div class="scroll-indicator" @click="$emit('scroll-to', 'about')">
      <span>{{ t.hero.scrollExplore }}</span>
      <div class="scroll-mouse"><div class="scroll-dot"></div></div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  stats: { type: Array, default: () => [] },
})

defineEmits(['scroll-to'])

const displayedText = ref('')
const currentTextIndex = ref(0)
let typewriterTimeout = null

function getTexts() {
  return props.t.hero.typewriter || []
}

function typeWriter(text, i, cb) {
  if (i < text.length) {
    displayedText.value += text.charAt(i)
    typewriterTimeout = setTimeout(() => typeWriter(text, i + 1, cb), 80)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, 2000)
  }
}

function deleteText(cb) {
  if (displayedText.value.length > 0) {
    displayedText.value = displayedText.value.slice(0, -1)
    typewriterTimeout = setTimeout(() => deleteText(cb), 40)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, 400)
  }
}

function startTypewriter() {
  const texts = getTexts()
  if (!texts.length) return
  currentTextIndex.value = currentTextIndex.value % texts.length
  const text = texts[currentTextIndex.value]
  typeWriter(text, 0, () => {
    deleteText(() => {
      currentTextIndex.value = (currentTextIndex.value + 1) % texts.length
      startTypewriter()
    })
  })
}

function restartTypewriter() {
  if (typewriterTimeout) clearTimeout(typewriterTimeout)
  displayedText.value = ''
  currentTextIndex.value = 0
  startTypewriter()
}

// Restart typewriter when language changes
watch(() => props.t, restartTypewriter)

onMounted(startTypewriter)
onUnmounted(() => {
  if (typewriterTimeout) clearTimeout(typewriterTimeout)
})
</script>

<style scoped>
.hero-section {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 120px 24px 140px;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  overflow: hidden;
  z-index: 0;
}

.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.35;
  animation: blobFloat 20s infinite ease-in-out;
}
.blob-1 {
  width: 500px;
  height: 500px;
  background: #667eea;
  top: -150px;
  left: -150px;
}
.blob-2 {
  width: 450px;
  height: 450px;
  background: #764ba2;
  bottom: -100px;
  right: -100px;
  animation-delay: -7s;
}
.blob-3 {
  width: 400px;
  height: 400px;
  background: #06b6d4;
  top: 30%;
  right: 10%;
  animation-delay: -14s;
}

@keyframes blobFloat {
  0%,
  100% {
    transform: translate(0, 0) scale(1);
  }
  33% {
    transform: translate(50px, -60px) scale(1.1);
  }
  66% {
    transform: translate(-40px, 40px) scale(0.95);
  }
}

.grid-overlay {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(148, 163, 184, 0.15) 1px, transparent 1px),
    linear-gradient(90deg, rgba(148, 163, 184, 0.15) 1px, transparent 1px);
  background-size: 50px 50px;
  mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
  -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
  opacity: 0.5;
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 840px;
  text-align: center;
}

.hero-chip {
  margin-bottom: 24px;
  font-weight: 500;
}

.hero-title {
  direction: rtl;
  font-size: clamp(2.5rem, 6vw, 4.5rem);
  font-weight: 800;
  line-height: 1.2;
  margin: 0 0 16px;
  letter-spacing: -0.02em;
}

.lang-fa .hero-title {
  letter-spacing: 0;
  line-height: 1.5;
}

.gradient-text {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.typewriter-container {
  direction: rtl;
  font-size: clamp(1.25rem, 3vw, 1.75rem);
  font-weight: 600;
  color: #475569;
  margin-bottom: 24px;
  min-height: 2.5em;
}
.body--dark .typewriter-container {
  color: #cbd5e1;
}

.typewriter-text {
  color: #667eea;
  font-weight: 700;
}
.body--dark .typewriter-text {
  color: #a78bfa;
}

.typewriter-cursor {
  display: inline-block;
  color: #667eea;
  font-weight: 300;
  animation: cursorBlink 1s infinite;
  margin-left: 2px;
  font-family: 'Inter', sans-serif !important;
}
.body--dark .typewriter-cursor {
  color: #a78bfa;
}

@keyframes cursorBlink {
  0%,
  50% {
    opacity: 1;
  }
  51%,
  100% {
    opacity: 0;
  }
}

.hero-description {
  direction: rtl;
  font-size: 1.1rem;
  line-height: 1.8;
  color: #475569;
  max-width: 650px;
  margin: 0 auto 40px;
}
.body--dark .hero-description {
  color: #cbd5e1;
}

.hero-actions {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 50px;
}

.btn-primary-grad {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  color: white;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
  transition: all 0.3s ease;
}
.btn-primary-grad:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(102, 126, 234, 0.5);
}

.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 16px;
  max-width: 700px;
  margin: 0 auto;
  width: 100%;
}

.stat-card {
  padding: 20px 16px;
  text-align: center;
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}
.body--dark .stat-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}

.stat-value {
  font-size: 2rem;
  font-weight: 800;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1;
  margin-bottom: 4px;
  font-family: 'Inter', sans-serif !important;
}
.stat-suffix {
  font-size: 1.5rem;
}
.stat-label {
  font-size: 0.875rem;
  color: #64748b;
  font-weight: 500;
}

@media (max-width: 600px) {
  .hero-section {
    padding: 85px 16px 50px;
    min-height: auto;
  }
  .hero-title {
    font-size: clamp(1.6rem, 6vw, 2.2rem);
    margin-bottom: 12px;
  }
  .typewriter-container {
    font-size: clamp(1rem, 4vw, 1.25rem);
    min-height: 2.2em;
    margin-bottom: 16px;
  }
  .hero-description {
    font-size: 0.95rem;
    line-height: 1.65;
    margin-bottom: 24px;
  }
  .hero-actions {
    gap: 10px;
    margin-bottom: 30px;
  }
  .hero-actions .q-btn {
    padding: 8px 16px;
    font-size: 0.9rem;
  }
  .stats-row {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
  }
  .stat-card {
    padding: 12px 6px;
    border-radius: 12px;
  }
  .stat-value {
    font-size: 1.35rem;
  }
  .stat-suffix {
    font-size: 1.1rem;
  }
  .stat-label {
    font-size: 0.72rem;
    line-height: 1.2;
    overflow-wrap: break-word;
  }
  .scroll-indicator {
    display: none;
  }
}

.scroll-indicator {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.3s ease;
  z-index: 2;
}
.scroll-indicator:hover {
  opacity: 1;
}
.scroll-indicator span {
  display: block;
  font-size: 0.75rem;
  color: #94a3b8;
  margin-bottom: 8px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}
.lang-fa .scroll-indicator span {
  letter-spacing: 0;
  text-transform: none;
}

.scroll-mouse {
  width: 24px;
  height: 38px;
  border: 2px solid #94a3b8;
  border-radius: 12px;
  margin: 0 auto;
  position: relative;
}
.scroll-dot {
  width: 4px;
  height: 8px;
  background: #667eea;
  border-radius: 2px;
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  animation: scrollDown 2s infinite;
}
@keyframes scrollDown {
  0% {
    transform: translate(-50%, 0);
    opacity: 1;
  }
  100% {
    transform: translate(-50%, 16px);
    opacity: 0;
  }
}
</style>
