<template>
  <section v-if="hasData" id="hero" class="hero-section">
    <div class="hero-bg">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>
      <div class="blob blob-3"></div>
      <div class="grid-overlay"></div>
    </div>

    <div class="hero-content">
      <!-- Job Availability & Status Badge -->
      <div v-if="showAvailabilityBadge" class="hero-badge-wrapper">
        <div class="availability-chip" :class="availabilityChipClass">
          <span v-if="hasPulseIndicator" class="pulse-indicator-dot">
            <span class="ping-wave"></span>
            <span class="dot-core"></span>
          </span>
          <q-icon v-else name="auto_awesome" size="16px" class="q-mr-xs" />
          <span class="badge-label">{{ availabilityBadgeText }}</span>
        </div>
      </div>

      <!-- Main Heading / Title -->
      <h1 class="hero-title">
        <template v-if="displayGreeting">{{ displayGreeting }} </template>
        <span class="gradient-text">{{ displayName }}</span>
      </h1>

      <div v-if="customTitle" class="hero-subtitle">
        {{ customTitle }}
      </div>

      <!-- Dynamic Typewriter Effect -->
      <div v-if="isTypewriterEnabled" class="typewriter-container">
        <span v-if="displayTypewriterPrefix" class="typewriter-prefix">{{ displayTypewriterPrefix }}</span>
        <span class="typewriter-text">{{ displayedText }}</span>
        <span class="typewriter-cursor">|</span>
      </div>

      <!-- Description / Bio -->
      <p class="hero-description" v-html="displayDescription"></p>

      <!-- Action Buttons Builder -->
      <div class="hero-actions" v-if="actionButtons.length > 0">
        <template v-for="(btn, idx) in actionButtons" :key="idx">
          <q-btn
            :label="btn.label"
            :icon="btn.icon || undefined"
            :icon-right="btn.icon_right || undefined"
            :size="btn.size || 'lg'"
            no-caps
            rounded
            :outline="btn.variant === 'outline'"
            :flat="btn.variant === 'flat'"
            :unelevated="btn.variant !== 'outline' && btn.variant !== 'flat'"
            :class="getButtonClass(btn)"
            :color="getButtonColor(btn)"
            @click="handleButtonClick(btn)"
          />
        </template>
      </div>

      <!-- Stats Counters Builder -->
      <div class="stats-row" v-if="computedStats && computedStats.length > 0">
        <div
          v-for="(stat, idx) in computedStats"
          :key="idx"
          class="stat-card"
          :style="{ animationDelay: idx * 0.1 + 's' }"
        >
          <div class="stat-value">
            <span>{{ stat.animated !== undefined ? stat.animated : stat.value }}</span>
            <span class="stat-suffix">{{ stat.suffix || '' }}</span>
          </div>
          <div class="stat-label">{{ stat.label }}</div>
        </div>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div
      v-if="showScrollIndicator"
      class="scroll-indicator"
      @click="$emit('scroll-to', 'about')"
    >
      <span>{{ scrollIndicatorLabel }}</span>
      <div class="scroll-mouse"><div class="scroll-dot"></div></div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  stats: { type: Array, default: () => [] },
  heroData: { type: Object, default: null },
})

const emit = defineEmits(['scroll-to'])

const hasData = computed(() => {
  if (props.heroData && props.heroData.is_active !== false) {
    return Boolean(
      props.heroData.name ||
        props.heroData.greeting ||
        props.heroData.title ||
        props.heroData.description,
    )
  }
  return Boolean(
    props.t?.hero &&
      (props.t.hero.greeting || props.t.hero.name || (props.stats && props.stats.length > 0)),
  )
})

// Availability status and badge
const showAvailabilityBadge = computed(() => {
  if (props.heroData && props.heroData.show_availability !== undefined) {
    return Boolean(props.heroData.show_availability)
  }
  return Boolean(props.t?.hero?.badge)
})

const availabilityStatus = computed(() => {
  return props.heroData?.availability_status || 'available'
})

const availabilityChipClass = computed(() => {
  const status = availabilityStatus.value
  return `status-${status}`
})

const hasPulseIndicator = computed(() => {
  if (props.heroData && props.heroData.availability_pulse !== undefined) {
    return Boolean(props.heroData.availability_pulse)
  }
  return true
})

const availabilityBadgeText = computed(() => {
  if (props.heroData && props.heroData.badge_text) {
    return props.heroData.badge_text
  }
  return props.t?.hero?.badge || 'Available for opportunities'
})

// Main texts
const displayGreeting = computed(() => {
  if (props.heroData && props.heroData.greeting !== null && props.heroData.greeting !== undefined) {
    return props.heroData.greeting
  }
  return props.t?.hero?.greeting || ''
})

const displayName = computed(() => {
  if (props.heroData && props.heroData.name !== null && props.heroData.name !== undefined) {
    return props.heroData.name
  }
  return props.t?.hero?.name || ''
})

const customTitle = computed(() => {
  return props.heroData?.title || ''
})

const displayDescription = computed(() => {
  if (props.heroData && props.heroData.description) {
    return props.heroData.description
  }
  return props.t?.hero?.description || ''
})

// Typewriter Effect
const isTypewriterEnabled = computed(() => {
  if (props.heroData && props.heroData.enable_typewriter !== undefined) {
    return Boolean(props.heroData.enable_typewriter)
  }
  return true
})

const displayTypewriterPrefix = computed(() => {
  if (
    props.heroData &&
    props.heroData.typewriter_prefix !== null &&
    props.heroData.typewriter_prefix !== undefined
  ) {
    return props.heroData.typewriter_prefix
  }
  return props.t?.hero?.prefix || ''
})

const typewriterStrings = computed(() => {
  if (
    props.heroData &&
    Array.isArray(props.heroData.typewriter_strings) &&
    props.heroData.typewriter_strings.length > 0
  ) {
    return props.heroData.typewriter_strings
  }
  return props.t?.hero?.typewriter || []
})

const typewriterTypeSpeed = computed(() => props.heroData?.typewriter_speed || 80)
const typewriterDeleteSpeed = computed(() => props.heroData?.typewriter_delete_speed || 40)
const typewriterHoldDelay = computed(() => props.heroData?.typewriter_delay || 2000)

const displayedText = ref('')
const currentTextIndex = ref(0)
let typewriterTimeout = null

function typeWriter(text, i, cb) {
  if (i < text.length) {
    displayedText.value += text.charAt(i)
    typewriterTimeout = setTimeout(() => typeWriter(text, i + 1, cb), typewriterTypeSpeed.value)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, typewriterHoldDelay.value)
  }
}

function deleteText(cb) {
  if (displayedText.value.length > 0) {
    displayedText.value = displayedText.value.slice(0, -1)
    typewriterTimeout = setTimeout(() => deleteText(cb), typewriterDeleteSpeed.value)
  } else if (cb) {
    typewriterTimeout = setTimeout(cb, 400)
  }
}

function startTypewriter() {
  if (!isTypewriterEnabled.value) return
  const texts = typewriterStrings.value
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

watch([() => props.t, () => props.heroData], restartTypewriter, { deep: true })

// Buttons Builder
const actionButtons = computed(() => {
  if (
    props.heroData &&
    Array.isArray(props.heroData.buttons) &&
    props.heroData.buttons.length > 0
  ) {
    return props.heroData.buttons
  }
  // Default fallback buttons from i18n
  return [
    {
      label: props.t?.hero?.viewWork || 'View My Work',
      variant: 'primary_gradient',
      icon_right: 'arrow_forward',
      action_type: 'scroll',
      target: 'projects',
      size: 'lg',
    },
    {
      label: props.t?.hero?.getInTouch || 'Get in Touch',
      variant: 'outline',
      icon: 'mail',
      action_type: 'scroll',
      target: 'contact',
      size: 'lg',
    },
  ]
})

function getButtonClass(btn) {
  const classes = []
  if (btn.variant === 'primary_gradient' || !btn.variant) {
    classes.push('btn-primary-grad')
  } else if (btn.variant === 'glass') {
    classes.push('btn-glass')
  }
  return classes.join(' ')
}

function getButtonColor(btn) {
  if (btn.variant === 'outline' || btn.variant === 'flat') {
    return 'primary'
  }
  if (btn.variant === 'secondary') {
    return 'secondary'
  }
  return 'primary'
}

function handleButtonClick(btn) {
  const action = btn.action_type || 'scroll'
  const target = btn.target || ''

  if (action === 'scroll') {
    emit('scroll-to', target.replace('#', ''))
  } else if (action === 'email') {
    const emailTarget = target.startsWith('mailto:') ? target : `mailto:${target}`
    window.location.href = emailTarget
  } else if (action === 'link') {
    if (btn.new_tab) {
      window.open(target, '_blank', 'noopener,noreferrer')
    } else {
      window.location.href = target
    }
  }
}

// Stats Builder
const animatedStats = ref([])

function startStatsAnimation() {
  const targetList =
    props.heroData && Array.isArray(props.heroData.stats) && props.heroData.stats.length > 0
      ? props.heroData.stats
      : props.stats

  animatedStats.value = targetList.map(() => 0)

  targetList.forEach((stat, idx) => {
    const targetVal = Number(stat.value) || 0
    if (targetVal <= 0) {
      animatedStats.value[idx] = 0
      return
    }

    let current = 0
    const duration = 1800
    const stepTime = 30
    const steps = duration / stepTime
    const increment = targetVal / steps

    const interval = setInterval(() => {
      current += increment
      if (current >= targetVal) {
        animatedStats.value[idx] = targetVal
        clearInterval(interval)
      } else {
        animatedStats.value[idx] = Math.floor(current)
      }
    }, stepTime)
  })
}

watch(
  () => [props.heroData?.stats, props.stats],
  () => {
    startStatsAnimation()
  },
  { deep: true, immediate: true }
)

const computedStats = computed(() => {
  if (props.heroData && Array.isArray(props.heroData.stats) && props.heroData.stats.length > 0) {
    return props.heroData.stats.map((s, idx) => ({
      value: s.value,
      label: s.label,
      suffix: s.suffix || '',
      animated: animatedStats.value[idx] !== undefined ? animatedStats.value[idx] : s.value,
    }))
  }
  return props.stats.map((stat, idx) => ({
    ...stat,
    label: props.t?.stats?.[idx]?.label || stat.label,
    animated: animatedStats.value[idx] !== undefined ? animatedStats.value[idx] : (stat.animated || stat.value),
  }))
})

// Scroll Indicator
const showScrollIndicator = computed(() => {
  if (props.heroData && props.heroData.show_scroll_indicator !== undefined) {
    return Boolean(props.heroData.show_scroll_indicator)
  }
  return true
})

const scrollIndicatorLabel = computed(() => {
  if (props.heroData && props.heroData.scroll_indicator_text) {
    return props.heroData.scroll_indicator_text
  }
  return props.t?.hero?.scrollExplore || 'Scroll to explore'
})

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

/* Availability Badge & Pulsing Indicator */
.hero-badge-wrapper {
  display: flex;
  justify-content: center;
  margin-bottom: 24px;
}

.availability-chip {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 16px;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 600;
  backdrop-filter: blur(12px);
  border: 1px solid;
  transition: all 0.3s ease;
}

.availability-chip.status-available {
  background: rgba(16, 185, 129, 0.12);
  color: #10b981;
  border-color: rgba(16, 185, 129, 0.3);
}

.availability-chip.status-open_to_work {
  background: rgba(99, 102, 241, 0.12);
  color: #6366f1;
  border-color: rgba(99, 102, 241, 0.3);
}

.availability-chip.status-busy {
  background: rgba(245, 158, 11, 0.12);
  color: #f59e0b;
  border-color: rgba(245, 158, 11, 0.3);
}

.availability-chip.status-unavailable {
  background: rgba(100, 116, 139, 0.12);
  color: #64748b;
  border-color: rgba(100, 116, 139, 0.3);
}

.pulse-indicator-dot {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 10px;
  height: 10px;
}

.pulse-indicator-dot .ping-wave {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: currentColor;
  opacity: 0.75;
  animation: pingAnimation 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
}

.pulse-indicator-dot .dot-core {
  position: relative;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: currentColor;
}

@keyframes pingAnimation {
  75%,
  100% {
    transform: scale(2.4);
    opacity: 0;
  }
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

.hero-subtitle {
  font-size: clamp(1.2rem, 3vw, 1.6rem);
  font-weight: 700;
  color: #64748b;
  margin-bottom: 16px;
}
.body--dark .hero-subtitle {
  color: #94a3b8;
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

.btn-glass {
  background: rgba(255, 255, 255, 0.15) !important;
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: inherit;
  transition: all 0.3s ease;
}
.btn-glass:hover {
  background: rgba(255, 255, 255, 0.25) !important;
  transform: translateY(-2px);
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
  background-clip: text;
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
