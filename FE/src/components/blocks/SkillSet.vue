<template>
  <section id="skills" class="section section-alt">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.skills.subtitle }}</span>
        <h2 class="section-title">{{ t.skills.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="skills-grid">
        <div v-for="n in 8" :key="n" class="skill-card skeleton-card">
          <div class="shimmer-circle shimmer"></div>
          <div class="shimmer-line shimmer w-60 q-mt-sm"></div>
          <div class="shimmer-line shimmer w-40 q-mt-sm"></div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="empty-state">
        <div class="empty-icon"><q-icon name="error_outline" size="64px" color="negative" /></div>
        <h3 class="empty-title">{{ t.skills.error || 'Failed to load skills' }}</h3>
        <p class="empty-text">{{ error }}</p>
        <q-btn
          color="primary"
          label="Try Again"
          no-caps
          rounded
          icon="refresh"
          @click="$emit('retry')"
        />
      </div>

      <!-- Empty State -->
      <div v-else-if="displayCategories.length === 0" class="empty-state">
        <div class="empty-icon"><q-icon name="memory" size="64px" color="primary" /></div>
        <h3 class="empty-title">No Skills Found</h3>
      </div>

      <!-- Dynamic Skills Display -->
      <template v-else>
        <div class="skill-tabs-container">
          <div ref="trackRef" class="skill-tabs-track">
            <div class="active-sliding-indicator" :style="indicatorStyle"></div>
            <button
              v-for="(cat, idx) in displayCategories"
              :key="cat.id || cat.name"
              :ref="(el) => setTabRef(el, idx)"
              class="skill-tab-btn"
              :class="{ active: activeCategory === cat.name }"
              @click="activeCategory = cat.name"
            >
              {{ cat.name }}
            </button>
          </div>
        </div>

        <transition-group name="skill-fade" tag="div" class="skills-grid">
          <div v-for="skill in currentSkills" :key="skill.id || skill.name" class="skill-card">
            <div class="skill-icon-wrapper">
              <img
                v-if="hasCustomIcon(skill) && !failedIconUrls.has(getSkillIconUrl(skill))"
                :src="getSkillIconUrl(skill)"
                :alt="skill.name"
                class="skill-custom-icon"
                @error="handleIconError(getSkillIconUrl(skill))"
              />
              <q-icon v-else :name="getSkillIcon(skill.name)" size="32px" color="primary" />
            </div>
            <div class="skill-name">{{ skill.name }}</div>
            <div class="skill-level">{{ getSkillLevelLabel(skill) }}</div>
          </div>
        </transition-group>
      </template>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount, nextTick } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
  categories: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false },
  error: { type: String, default: null },
})

defineEmits(['retry'])

const staticCategories = [
  {
    name: 'Backend',
    skills: [
      { name: 'PHP', level: 'expert' },
      { name: 'Laravel', level: 'intermediate' },
      { name: 'MySQL', level: 'intermediate' },
      { name: 'SQL', level: 'intermediate' },
      { name: 'REST APIs', level: 'expert' },
    ],
  },
  {
    name: 'Frontend',
    skills: [
      { name: 'JavaScript', level: 'intermediate' },
      { name: 'Vue.js', level: 'intermediate' },
      { name: 'HTML5', level: 'expert' },
      { name: 'CSS3', level: 'intermediate' },
      { name: 'Bootstrap', level: 'intermediate' },
      { name: 'jQuery', level: 'intermediate' },
    ],
  },
  {
    name: 'DevOps',
    skills: [
      { name: 'Git', level: 'intermediate' },
      { name: 'GitHub', level: 'intermediate' },
      { name: 'Apache', level: 'beginner' },
      { name: 'Nginx', level: 'beginner' },
      { name: 'Linux', level: 'beginner' },
    ],
  },
  {
    name: 'Design',
    skills: [
      { name: 'Photoshop', level: 'intermediate' },
      { name: 'Illustrator', level: 'beginner' },
      { name: 'After Effects', level: 'beginner' },
      { name: 'Premiere Pro', level: 'beginner' },
    ],
  },
]

const displayCategories = computed(() => {
  if (Array.isArray(props.categories) && props.categories.length > 0) {
    return props.categories.map((c) => ({
      id: c.id,
      name: c.name,
      skills: Array.isArray(c.skills)
        ? c.skills
        : Array.isArray(c.items)
          ? c.items.map((i) => (typeof i === 'string' ? { name: i, level: 'intermediate' } : i))
          : [],
    }))
  }
  return staticCategories
})

const activeCategory = ref(displayCategories.value[0]?.name || 'Backend')

watch(
  displayCategories,
  (newVal) => {
    if (newVal && newVal.length > 0) {
      if (!newVal.some((c) => c.name === activeCategory.value)) {
        activeCategory.value = newVal[0].name
      }
    }
  },
  { immediate: true },
)

const trackRef = ref(null)
const tabRefs = ref({})
const indicatorStyle = ref({})

function setTabRef(el, idx) {
  if (el) {
    tabRefs.value[idx] = el
  }
}

function updateIndicator() {
  nextTick(() => {
    const activeIndex = displayCategories.value.findIndex((c) => c.name === activeCategory.value)
    if (activeIndex === -1 || !tabRefs.value[activeIndex]) return
    const activeTab = tabRefs.value[activeIndex]

    indicatorStyle.value = {
      left: `${activeTab.offsetLeft}px`,
      top: `${activeTab.offsetTop}px`,
      width: `${activeTab.offsetWidth}px`,
      height: `${activeTab.offsetHeight}px`,
      opacity: 1,
    }
  })
}

watch(activeCategory, () => {
  updateIndicator()
})

onMounted(() => {
  nextTick(() => {
    updateIndicator()
  })
  setTimeout(updateIndicator, 100)
  if (document.fonts) {
    document.fonts.ready.then(updateIndicator)
  }
  window.addEventListener('resize', updateIndicator)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateIndicator)
})

const currentSkills = computed(() => {
  const cat = displayCategories.value.find((c) => c.name === activeCategory.value)
  return cat ? cat.skills : []
})

function getSkillIcon(techName) {
  const name = String(techName || '')
  const icons = {
    PHP: 'code',
    Laravel: 'extension',
    MySQL: 'storage',
    SQL: 'storage',
    JavaScript: 'javascript',
    'Vue.js': 'web',
    Vue: 'web',
    HTML5: 'html',
    HTML: 'html',
    CSS3: 'css',
    CSS: 'css',
    Bootstrap: 'palette',
    jQuery: 'code',
    Git: 'call_split',
    GitHub: 'fab fa-github',
    Apache: 'dns',
    Nginx: 'dns',
    Linux: 'computer',
    'REST APIs': 'api',
    API: 'api',
    Photoshop: 'image',
    Illustrator: 'brush',
    'After Effects': 'movie',
    'Premiere Pro': 'videocam',
  }
  return icons[name] || 'memory'
}

function getSkillLevelLabel(skillObj) {
  if (!skillObj) return 'intermediate'
  const level = skillObj.level ?? skillObj
  if (typeof level === 'string' && level.trim() !== '') {
    return level.toLowerCase()
  }
  return 'intermediate'
}

const failedIconUrls = ref(new Set())

function handleIconError(url) {
  if (url) {
    failedIconUrls.value.add(url)
  }
}

function hasCustomIcon(skill) {
  const url = skill?.iconUrl || skill?.icon_url || skill?.icon
  return Boolean(url && typeof url === 'string' && url.trim().length > 0)
}

function getSkillIconUrl(skill) {
  const url = skill?.iconUrl || skill?.icon_url || skill?.icon
  if (!url) return ''
  if (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:')) {
    return url
  }
  const cleanPath = url.startsWith('/') ? url : `/${url}`
  if (cleanPath.startsWith('/storage/')) {
    return `http://127.0.0.1:8000${cleanPath}`
  }
  return `http://127.0.0.1:8000/storage${cleanPath}`
}
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
.section-alt {
  background: #f8fafc;
}
.body--dark .section-alt {
  background: #0f172a;
}
.section-container {
  max-width: 1200px;
  margin: 0 auto;
}
.section-header {
  text-align: center;
  margin-bottom: 50px;
}
.section-subtitle {
  display: inline-block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #667eea;
  text-transform: uppercase;
  letter-spacing: 0.15em;
}
.lang-fa .section-subtitle {
  text-transform: none;
  letter-spacing: 0;
}
.section-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  margin: 8px 0 20px;
}
.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  margin: 0 auto;
  border-radius: 2px;
}

.skill-tabs-container {
  display: flex;
  justify-content: center;
  margin-bottom: 40px;
}

.skill-tabs-track {
  position: relative;
  display: inline-flex;
  align-items: center;
  padding: 6px;
  background: rgba(255, 255, 255, 0.7);
  border: 1px solid rgba(102, 126, 234, 0.2);
  border-radius: 9999px;
  box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
  backdrop-filter: blur(12px);
  max-width: 100%;
  flex-wrap: wrap;
  justify-content: center;
}

@media (max-width: 600px) {
  .skill-tabs-track {
    flex-wrap: nowrap;
    overflow-x: auto;
    justify-content: flex-start;
    border-radius: 16px;
    padding: 4px;
    width: 100%;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
  }
  .skill-tabs-track::-webkit-scrollbar {
    display: none;
  }
  .skill-tab-btn {
    padding: 8px 16px;
    font-size: 0.85rem;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .skills-grid {
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
  }
  .skill-card {
    padding: 16px;
  }
}

.body--dark .skill-tabs-track {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.active-sliding-indicator {
  position: absolute;
  border-radius: 9999px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  pointer-events: none;
  z-index: 1;
  opacity: 0;
}

.skill-tab-btn {
  position: relative;
  z-index: 2;
  padding: 10px 28px;
  border-radius: 9999px;
  font-size: 0.95rem;
  font-weight: 600;
  border: none;
  background: transparent !important;
  color: #64748b;
  cursor: pointer;
  transition: color 0.3s ease;
  outline: none;
  user-select: none;
}

.body--dark .skill-tab-btn {
  color: #94a3b8;
}

.skill-tab-btn:hover {
  color: #667eea;
}

.body--dark .skill-tab-btn:hover {
  color: #ffffff;
}

.skill-tab-btn.active {
  color: #ffffff !important;
}

.skills-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
}

.skill-card {
  padding: 24px;
  text-align: center;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.body--dark .skill-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.skill-card:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 12px 30px rgba(102, 126, 234, 0.2);
}

.skill-icon-wrapper {
  width: 60px;
  height: 60px;
  margin: 0 auto 16px;
  border-radius: 16px;
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15));
  display: flex;
  align-items: center;
  justify-content: center;
}
.skill-custom-icon {
  width: 32px;
  height: 32px;
  object-fit: contain;
}
.skill-name {
  font-weight: 700;
  font-size: 1.05rem;
  margin-bottom: 4px;
}
.skill-level {
  font-size: 0.85rem;
  font-weight: 500;
  color: #64748b;
  text-transform: lowercase;
}
.body--dark .skill-level {
  color: #94a3b8;
}

.skeleton-card {
  height: 140px;
}
.shimmer-circle {
  width: 48px;
  height: 48px;
  border-radius: 12px;
}
.shimmer-line {
  height: 10px;
  border-radius: 4px;
}
.w-60 {
  width: 60%;
}
.w-40 {
  width: 40%;
}
.shimmer {
  background: linear-gradient(
    90deg,
    rgba(200, 200, 200, 0.15) 25%,
    rgba(200, 200, 200, 0.3) 50%,
    rgba(200, 200, 200, 0.15) 75%
  );
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
}
.empty-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 8px;
}
.empty-text {
  color: #64748b;
  margin-bottom: 24px;
}
</style>