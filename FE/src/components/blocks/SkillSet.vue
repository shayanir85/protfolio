<template>
  <section id="skills" class="section section-alt">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.skills.subtitle }}</span>
        <h2 class="section-title">{{ t.skills.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <div class="skill-tabs-container">
        <div ref="trackRef" class="skill-tabs-track">
          <div class="active-sliding-indicator" :style="indicatorStyle"></div>
          <button
            v-for="(cat, idx) in categories"
            :key="cat.name"
            :ref="(el) => (tabRefs[idx] = el)"
            class="skill-tab-btn"
            :class="{ active: activeCategory === cat.name }"
            @click="activeCategory = cat.name"
          >
            {{ cat.name }}
          </button>
        </div>
      </div>

      <transition-group name="skill-fade" tag="div" class="skills-grid">
        <div v-for="tech in currentSkills" :key="tech" class="skill-card">
          <div class="skill-icon-wrapper">
            <q-icon :name="getSkillIcon(tech)" size="32px" color="primary" />
          </div>
          <div class="skill-name">{{ tech }}</div>
          <q-linear-progress
            :value="getSkillLevel(tech) / 100"
            color="primary"
            track-color="grey-3"
            rounded
            size="6px"
            class="skill-bar"
          />
        </div>
      </transition-group>

      <div class="skill-bars-wrapper">
        <h3 class="proficiency-title">{{ t.skills.proficiency }}</h3>
        <div class="progress-bars">
          <div v-for="skill in skillLevels" :key="skill.name" class="progress-item">
            <div class="progress-header">
              <span class="progress-label">{{ skill.name }}</span>
              <span class="progress-value">{{ skill.level }}%</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" :style="{ width: skill.level + '%' }"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount, nextTick } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
})

const categories = [
  { name: 'Backend', items: ['PHP', 'Laravel', 'MySQL', 'SQL', 'REST APIs'] },
  { name: 'Frontend', items: ['JavaScript', 'Vue.js', 'HTML5', 'CSS3', 'Bootstrap', 'jQuery'] },
  { name: 'DevOps', items: ['Git', 'GitHub', 'Apache', 'Nginx', 'Linux'] },
  { name: 'Design', items: ['Photoshop', 'Illustrator', 'After Effects', 'Premiere Pro'] },
]

const activeCategory = ref(categories[0].name)
const trackRef = ref(null)
const tabRefs = ref([])
const indicatorStyle = ref({})

function updateIndicator() {
  nextTick(() => {
    const activeIndex = categories.findIndex((c) => c.name === activeCategory.value)
    if (activeIndex === -1 || !trackRef.value || !tabRefs.value[activeIndex]) return
    const track = trackRef.value.getBoundingClientRect()
    const activeTab = tabRefs.value[activeIndex].getBoundingClientRect()

    indicatorStyle.value = {
      left: `${activeTab.left - track.left}px`,
      top: `${activeTab.top - track.top}px`,
      width: `${activeTab.width}px`,
      height: `${activeTab.height}px`,
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
  const cat = categories.find((c) => c.name === activeCategory.value)
  return cat ? cat.items : []
})

const skillLevels = props.data?.skills || [
  { name: 'PHP', level: 85 },
  { name: 'Laravel', level: 75 },
  { name: 'MySQL', level: 80 },
  { name: 'JavaScript', level: 70 },
  { name: 'Vue.js', level: 65 },
  { name: 'Git', level: 75 },
]

function getSkillIcon(tech) {
  const icons = {
    PHP: 'code',
    Laravel: 'extension',
    MySQL: 'storage',
    SQL: 'storage',
    JavaScript: 'javascript',
    'Vue.js': 'web',
    HTML5: 'html',
    CSS3: 'css',
    Bootstrap: 'palette',
    jQuery: 'code',
    Git: 'call_split',
    GitHub: 'fab fa-github',
    Apache: 'dns',
    Nginx: 'dns',
    Linux: 'computer',
    'REST APIs': 'api',
    Photoshop: 'image',
    Illustrator: 'brush',
    'After Effects': 'movie',
    'Premiere Pro': 'videocam',
  }
  return icons[tech] || 'memory'
}

function getSkillLevel(tech) {
  const found = skillLevels.find((s) => s.name.toLowerCase() === tech.toLowerCase())
  if (found) return found.level
  const levels = {
    PHP: 85,
    Laravel: 80,
    MySQL: 80,
    SQL: 75,
    JavaScript: 70,
    'Vue.js': 65,
    HTML5: 85,
    CSS3: 80,
    Git: 75,
    GitHub: 80,
  }
  return levels[tech] || 70
}
</script>

<style scoped>
.section {
  padding: 90px 24px;
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
  margin-bottom: 60px;
}

.skill-card {
  padding: 24px;
  text-align: center;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  transition: all 0.3s ease;
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
.skill-name {
  font-weight: 600;
  margin-bottom: 12px;
}

.skill-bars-wrapper {
  max-width: 700px;
  margin: 0 auto;
}
.proficiency-title {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 28px;
  text-align: center;
}
.progress-item {
  margin-bottom: 20px;
}
.progress-header {
  display: flex;
  justify-content: space-between;
  font-weight: 600;
  margin-bottom: 8px;
}
.progress-track {
  height: 8px;
  background: rgba(148, 163, 184, 0.2);
  border-radius: 4px;
  overflow: hidden;
}
.progress-fill {
  height: 100%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-radius: 4px;
  transition: width 1s ease-in-out;
}
</style>
