<template>
  <section v-if="displayItems && displayItems.length > 0" id="experience" class="section">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.experience.subtitle }}</span>
        <h2 class="section-title">{{ t.experience.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <div class="timeline">
        <div
          v-for="(exp, idx) in displayItems"
          :key="exp.id || idx"
          class="timeline-item"
          :class="idx % 2 === 0 ? 'left' : 'right'"
        >
          <div class="timeline-marker">
            <q-icon :name="exp.icon || 'work'" color="white" size="20px" />
          </div>
          <div class="timeline-content">
            <div class="timeline-period">{{ exp.period }}</div>
            <h3 class="timeline-title">{{ exp.position || exp.title }}</h3>
            <div class="timeline-company">
              <q-icon name="business" size="xs" class="q-mr-xs" />
              {{ exp.title || exp.company }}
            </div>
            <q-separator v-if="exp.explanation || (exp.duties && exp.duties.length)" class="q-my-md" />
            <div v-if="exp.explanation" class="timeline-explanation q-mb-sm" style="white-space: pre-line;">{{ exp.explanation }}</div>
            <ul v-if="exp.duties && exp.duties.length" class="timeline-duties">
              <li v-for="(duty, i) in exp.duties" :key="i" v-html="duty"></li>
            </ul>
          </div>
        </div>
      </div>

      <div v-if="goalsList && goalsList.length > 0" class="goals-wrapper">
        <div class="goals-card">
          <div class="goals-header">
            <q-icon name="flag" color="primary" size="28px" />
            <h3 class="goals-title">{{ t.experience.goalsTitle }}</h3>
          </div>
          <div class="goals-grid">
            <div v-for="(goal, i) in goalsList" :key="goal.id || i" class="goal-item">
              <q-icon :name="goal.icon || 'emoji_events'" color="primary" size="24px" />
              <div class="goal-text" v-html="goal.text"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
  experiences: { type: Array, default: () => [] },
  goals: { type: Array, default: () => [] },
})

const goalsList = computed(() => {
  if (Array.isArray(props.goals) && props.goals.length > 0) {
    return props.goals
  }
  return []
})

const displayItems = computed(() => {
  if (props.experiences && props.experiences.length > 0) {
    return props.experiences.map((item) => {
      const periodStr = item.period
        ? item.period
        : item.end_date
          ? `${item.start_date} -> ${item.end_date}`
          : `${item.start_date} -> current job`

      return {
        id: item.id,
        title: item.title,
        position: item.position,
        explanation: item.explanation,
        company: item.company || item.title,
        period: periodStr,
        icon: item.icon || 'work',
        duties: item.duties || [],
      }
    })
  }
  return props.t.experience?.items || []
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

.timeline {
  position: relative;
  max-width: 900px;
  margin: 0 auto 60px;
}
.timeline::after {
  content: '';
  position: absolute;
  width: 4px;
  background: linear-gradient(180deg, #667eea, #764ba2);
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -2px;
  border-radius: 2px;
}

.timeline-item {
  padding: 10px 40px;
  position: relative;
  width: 50%;
  box-sizing: border-box;
}
.timeline-item.left {
  left: 0;
}
.timeline-item.right {
  left: 50%;
}

/* RTL timeline adjustments */
[dir='rtl'] .timeline-item.left {
  left: 50%;
  right: auto;
}
[dir='rtl'] .timeline-item.right {
  left: 0;
  right: auto;
}

.timeline-marker {
  position: absolute;
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-radius: 50%;
  top: 20px;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
.timeline-item.left .timeline-marker {
  right: -20px;
  left: auto;
}
.timeline-item.right .timeline-marker {
  left: -20px;
  right: auto;
}
[dir='rtl'] .timeline-item.left .timeline-marker {
  left: -20px;
  right: auto;
}
[dir='rtl'] .timeline-item.right .timeline-marker {
  right: -20px;
  left: auto;
}

.timeline-content {
  direction: rtl;
  padding: 24px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.body--dark .timeline-content {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}

.timeline-period {
  font-size: 0.85rem;
  font-weight: 700;
  color: #667eea;
  text-transform: uppercase;
  margin-bottom: 4px;
}
.lang-fa .timeline-period {
  text-transform: none;
  font-family: 'B Nazanin', 'Tahoma', sans-serif;
}
.timeline-title {
  font-size: 1.3rem;
  font-weight: 700;
  margin: 0 0 6px;
}
.timeline-company {
  font-size: 0.95rem;
  color: #64748b;
  display: flex;
  align-items: center;
}
.timeline-duties {
  margin: 0;
  padding-inline-start: 20px;
  color: #475569;
  line-height: 1.8;
}
.body--dark .timeline-duties {
  color: #cbd5e1;
}

.goals-wrapper {
  max-width: 900px;
  margin: 40px auto 0;
}
.goals-card {
  padding: 30px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.body--dark .goals-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.goals-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}
.goals-title {
  font-size: 1.4rem;
  font-weight: 700;
  margin: 0;
}
.goals-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 16px;
}
.goal-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px;
  background: rgba(102, 126, 234, 0.05);
  border-radius: 12px;
}
.goal-text {
  font-size: 0.95rem;
  line-height: 1.5;
}

/* Mobile view responsive fixes for RTL and LTR */
@media (max-width: 768px) {
  .section {
    padding: 50px 16px;
  }
  .section-header {
    margin-bottom: 35px;
  }

  .timeline::after {
    left: 20px;
    right: auto;
    margin-left: -2px;
    margin-right: 0;
  }
  [dir='rtl'] .timeline::after {
    right: 20px;
    left: auto;
    margin-right: -2px;
    margin-left: 0;
  }

  .timeline-item,
  .timeline-item.left,
  .timeline-item.right,
  [dir='rtl'] .timeline-item.left,
  [dir='rtl'] .timeline-item.right {
    width: 100% !important;
    left: 0 !important;
    right: 0 !important;
    padding: 10px 0 10px 55px !important;
  }

  [dir='rtl'] .timeline-item,
  [dir='rtl'] .timeline-item.left,
  [dir='rtl'] .timeline-item.right {
    padding: 10px 55px 10px 0 !important;
  }

  .timeline-item .timeline-marker,
  .timeline-item.left .timeline-marker,
  .timeline-item.right .timeline-marker {
    left: 0 !important;
    right: auto !important;
  }

  [dir='rtl'] .timeline-item .timeline-marker,
  [dir='rtl'] .timeline-item.left .timeline-marker,
  [dir='rtl'] .timeline-item.right .timeline-marker {
    right: 0 !important;
    left: auto !important;
  }

  .timeline-content {
    padding: 18px;
  }

  .goals-card {
    padding: 20px 16px;
  }
}
</style>
