<template>
  <div class="pricing-tier-card glass-card">
    <div v-if="data?.is_popular" class="popular-badge">Popular Choice</div>
    <div class="plan-name">{{ data?.plan_name || 'Standard Plan' }}</div>
    <div class="plan-price">{{ data?.price || '$0' }}</div>
    <div class="plan-desc" v-if="data?.description">{{ data.description }}</div>
    <q-separator class="q-my-md" />
    <ul class="features-list">
      <li v-for="(feat, idx) in data?.features || []" :key="idx">
        <q-icon name="check_circle" color="primary" size="18px" class="q-mr-sm" />
        <span>{{ feat }}</span>
      </li>
    </ul>
    <q-btn
      color="primary"
      :label="data?.cta_text || 'Get Started'"
      :href="data?.cta_link || '#contact'"
      no-caps
      rounded
      unelevated
      class="full-width q-mt-lg btn-primary-grad"
    />
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<style scoped>
.pricing-tier-card {
  position: relative;
  padding: 32px 24px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  text-align: center;
}
.body--dark .pricing-tier-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.popular-badge {
  position: absolute;
  top: -12px;
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4px 16px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
}
.plan-name {
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 8px;
}
.plan-price {
  font-size: 2.2rem;
  font-weight: 800;
  color: #667eea;
  margin-bottom: 12px;
}
.features-list {
  list-style: none;
  padding: 0;
  margin: 0;
  text-align: left;
}
.features-list li {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  font-size: 0.95rem;
}
.btn-primary-grad {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>
